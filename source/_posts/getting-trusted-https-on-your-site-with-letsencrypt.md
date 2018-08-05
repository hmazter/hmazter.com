---
extends: _layouts.post
section: content

title: Getting trusted HTTPS on your site with letsencrypt
date: 2015-12-15
author: hmazter
category: Web servers
tags: apache, https, ssl
slug: getting-trusted-https-on-your-site-with-letsencrypt
---

> **NOTICE** The new script for Lets encrypt has been release which
simplifies install and getting a cert, check
out [certbot.eff.org](https://certbot.eff.org)

If you haven't heard about [Let's Encrypt](https://letsencrypt.org/) yet, 
read up on their site. It is a new,
free and automated Certificate Authority. This can easily be used
to get HTTPS support on your site for free and with  a small amount of
work.

Note! The cert from lets encrypt is only valid for 90 days and needs to
be renewed again after that.

Installing the lets encrypt wrapper script
------------------------------------------

Start with getting the lets encrypt script that will automate most of
the process for us. Clone from github and show the command help:

```bash
sudo git clone https://github.com/letsencrypt/letsencrypt
cd letsencrypt
sudo -H ./letsencrypt-auto --help # will check and download all dependencies
```

Setup SSL with trusted Cert on Apache
-------------------------------------

[Full Apache virtual host config
files](https://gist.github.com/hmazter/982c01d056fa7cd51c1c)

### Automatic (did not work for me)

1.  Run the automatic script  
   `sudo -H ./letsencrypt-auto --apache`
2.  Follow the onscreen guide to enter email, agree to terms of
    service and select domains
3.  Done!

### Manual steps (worked for me)

1.  Stop your apache server, to free up port 80  
   `sudo service apache2 stop`
2.  Run letsencrypt script which starts a standalone server and
    authorizes cert, set all domains that is going to be secured with
    this cert.  
   `sudo -H ./letsencrypt-auto certonly --standalone -d hmazter.com -d www.hmazter.com`
3.  First time you are prompted to enter your email and agree to the
    terms of service
4.  Edit apache virtual host config to include the cert created in
    previous step, the path to the files was outputted after successful
    creation. Mine was
    to `/etc/letsencrypt/live/hmazter.com/`
   Add this to your SSL virtual host config file (running on port 443):

    ```
    SSLEngine on
    SSLCertificateFile /path/to/file/fullchain.pem
    SSLCertificateKeyFile /path/to/file/privkey.pem
    ```

5.  Make sure that apache is listening to port 443
6.  Start apache  
   `sudo service apache2 start`
7.  Done!

Redirecting traffic from http to https
--------------------------------------

### Apache

If you want to redirect all traffic from http to https, which is a good
thing to do if its possible for you. Then this can easily be achieved
with apache Redirect directive. Add this to your HTTP virtual host: (but
use your full https url)

```
Redirect permanent / https://www.hmazter.com/
```

Other good links to read
------------------------

* [How To: Install A Free Trusted Certificate From LetsEncrypt](https://sysops.forlaravel.com/letsencrypt)
* [How It Works - Let's Encrypt](https://letsencrypt.org/howitworks/)
