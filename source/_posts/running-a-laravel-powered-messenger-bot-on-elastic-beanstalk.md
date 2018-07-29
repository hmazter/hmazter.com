---
extends: _layouts.post
section: content

title: Running a Laravel powered Messenger bot on Elastic Beanstalk
date: 2016-12-22 23:18
author: hmazter
category: Developing
tags: aws, facebook, laravel5, php, ssl
slug: running-a-laravel-powered-messenger-bot-on-elastic-beanstalk
---

Intro
-----

I read Mark Zuckerbergs [blog post about his home AI
Jarvis](https://www.facebook.com/notes/mark-zuckerberg/building-jarvis/10154361492931634/),
and was inspired. Not to build my own home AI, that would have been a
too large project for me right now, but to check out Facebook Messenger
bot.

I headed to the [Quick
Start section](https://developers.facebook.com/docs/messenger-platform/guides/quick-start)
of Messenger Platform and started following that.  
Set up a new Facebook Page, easy enough, just select a fitting category
for my test. Then create a new Facebook app and set up.  
Here was my first obstacle, the webhook for the FB app needs to point to
a public HTTPS URL. Let's figure out a way to easy fix that.

AWS Elastic Beanstalk
---------------------

Recently I have been testing and using more and more of the AWS tools
and services. Been using simple EC2 instances and S3 for years, but this
felt like a good opportunity to test out Elastic Beanstalk (EBS). I knew
I wanted to use PHP and Laravel for this project, which I like most
right now and am most efficient with. I had seen that the AMI used for
EBS was updated to support PHP 7.0 now, which wasn't the case last time
I was thinking about testing EBS.

So I created a new Laravel project. Googled and read up on how to use
the eb cli tool to deploy. This was my findings after some testing:

-   `eb init` - to
    create a new application
-   `eb create` - to
    create a new environment for the app
-   Use git to commit the code locally
-   `eb deploy` - to
    deploy the most recent commit to the EBS

It took some tweaking and testing with the configuration files for EBS
to get the document root to for the web server to point to: /public.
Ended up with this file (phpsettings.config) in the .ebextensions:

```
option_settings:
  aws:elasticbeanstalk:container:php:phpini:
    document_root: /public
```

After that I hade a working Laravel install on the machine. I saw a link
in the sidebar to use a custom domain with the EBS, and since I bought a
domain a couple of weeks ago in Route 53 for these sort of things I used
that one by adding a CNAME for the subdomain I chose pointing to the
full elaticbeanstalk.com URL. Now I had the app running on my custom
domain, but the requirement for the webhook was HTTPS.

HTTPS support
-------------

To get https, my first thought was Let's encrypt which
[I have used before](/2015/12/getting-trusted-https-on-your-site-with-letsencrypt).
After some quick Googling I saw something that reminded me of that AWS
has some certificate service, Amazon Certificate Manager (ACM). After
looking that up I set out to create a new wildcard certificate for my
domain.

Problem though, to verify the domain an email is sent to a couple of
addresses on that domain (admin, hostmaster, etc) and I don't have mail
running on that domain. My first thought, AWS must have a solution for
that. And right so, Simple Email Service (SES) can be set up to receive
emails on a domain, verify the domain by adding some TXT records and
then add the MX record for SES. Then set up a rule to store all incoming
emails to a S3 bucket.

Re-sent the verification email for the domain SSL certificate, and I got
some files in the S3 bucket, opened one, took the verify URL and
followed that. I got a message, verification successful. It took a
couple of minutes before the certification manager showed the domain as
verified.

Since I set up EBS with a single instance with a load balancer (ELB)
(may have not been necessary, but that was the default setting in eb
init) I needed to add a HTTPS listener to the load balancer. Listening
on port 443 externally and passing it to port 80 on the EC2 instance and
configure it with my new certificate. I did not get it to work directly,
that was because my security group for the load balancer did not allow
HTTPS traffic. After an update of the security group I had the app
running on the EBS with the load balancer handling both HTTP and HTTPS
traffic.

Start coding the bot app
------------------------

As I continued to follow the Quick Start guide for Messenger Platform I
saw the nodejs example. I know enough js to fully understand the example
and translate the functionality to PHP and fit in the Laravel
architecture.  
The first part was the actual verification of the webhook. A GET request
via HTTPS to a chosen URL, in the example they used /webhook and that
worked for me. Passed some query parameters, verify against my secret
token and then respond with another of the query parameters. In the
example they where written as hub.verify\_token and hub.challange and I
took that as some form of array in the parameters, but after some
testing I understood that it was just a string that included a period in
the name. Laravel replaces dots in query parameters with underscore, to
not conflict with the dot-notation for arrays.

```php
//WebhookController.php

// route: GET /webhook
public function webhookVerify(Request $request)
{
    $mode = $request->query('hub_mode');
    $verifyToken = $request->query('hub_verify_token');

    if ($mode === 'subscribe' && $verifyToken === config('services.messenger.verify_token')) {
        Log::info('Validating webhook');
        return (string)$request->query('hub_challenge');
    }

    Log::error('Failed validation. Make sure the validation tokens match.', [
        'mode' => $mode,
        'verify_token' => $verifyToken,
    ]);
    return abort(403);
}
```

I deployed the updated code to EBS with git commit and eb deploy. Then I
entered the URL in the FB webhook form, and the verification was
successful, and I subscribed the webhook to my FB page.

Next part was to handle POST requests to the webhook URL with messages.
Before I started that, I went to the FB page a wrote a message in the
chat. I saw in the access log of the web server on the EBS that I got a
POST request to the /webhook URL.

I updated my code to just log all data sent with the request and then
respond with a 200 status, which is a requirement of the messenger
platform.  
Then followed the example code to handle incoming text messages and
translating that to PHP.  
Right now my code only echos back the message or responds with some
different messages for some key words.

```php
// WbhookController.php

// route: POST /webhook
public function incoming(Request $request)
{
    // Make sure this is a page subscription
    if ($request->input('object') === 'page') {
        $entries = $request->input('entry');
        // Iterate over each entry - there may be multiple if batched
        foreach ($entries as $entry) {
            // Iterate over each messaging event
            foreach ($entry['messaging'] as $event) {
                if ($event['message']) {
                    $this->receivedMessage($event);
                } else {
                    Log::info('Webhook received unknown event: ', $event);
                }
            }
        }

        return response('', 200);
    }
}

private function receivedMessage(array $event)
{
    $message = $event['message'];
    $messageText = $message['text'] ?? false;
    if ($messageText) {
        // just echo the text we received.
        $this->sendTextMessage($senderID, $messageText);
    }
}

private function sendTextMessage($recipientId, $messageText)
{
    $messageData = [
        'recipient' => [
            'id' => $recipientId,
        ],
        'message' => [
            'text' => $messageText,
        ]
    ];

    $this->callSendAPI($messageData);
}

private function callSendAPI($messageData)
{
    $client = new Client();
    $client->post('https://graph.facebook.com/v2.6/me/messages', [
        'query' => [
            'access_token' => config('services.messenger.page_access_token')
        ],
        'json' => $messageData
    ]);
}
```

### Closing

Still a long way to go to actually doing something useful with the bot,
but it's a good proof of concept and a good opportunity to try out some
new technologies and services.

### Some things that could be improved:

-   Code cleanup and refactor when I know what the bot is going to do.
-   Figure out how to pass environment variables to the EBS (for PHP)
    without commit them either as the .env file or with the
    .ebextensions .config-files.
-   For a dev/PoC environment the load balancer with configured
    autoscaling was probably unnecessary.
-   Maybe use some of the pre-made bots/packages as a starting point.
