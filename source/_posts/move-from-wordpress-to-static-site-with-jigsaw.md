---
extends: _layouts.post
section: content

title: Move from wordpress to static site with Jigsaw
date: 2018-08-11
author: Kristoffer Högberg
slug: move-from-wordpress-to-static-site-with-jigsaw
---

I have read about the static site generator [Jigsaw](https://jigsaw.tighten.co/) the last couple of years.
And after seeing a lot of hype around [Netlify](https://www.netlify.com/) lately, I was thinking it could be a 
good idea the convert my blog running on Wordpress to a static site with Jigsaw.
Jigsaw builds on Laravel components and uses the templating engine from Laravel; Blade.
Since I'm mostly do my web development in with Laravel, this was a good choice for me.
Jigsaw also supports Markdown for pages, which is good since I wanted to write the actual blog posts in Markdown.
Seeing [Michael Dyrynda's post and video about getting Jigsaw up and running on Netlify]([https://dyrynda.com.au/blog/running-tighten-jigsaw-on-netlify])
I took that as a sign that now was the time to do it.

## Getting started

I started with the [Jigsaw installation](https://jigsaw.tighten.co/docs/installation/)
and installed and initialized a new folder
```bash
mkdir hmazter.com
cd hmazter.com
composer init
composer require tightenco/jigsaw
./vendor/bin/jigsaw init
```

## Export existing posts and convert to markdown

I don't have that many posts on this site, but those I have I wanted to keep on the new site.
After some searching I found the post about converting the exported xml from a wordpress site to markdown:
https://prefetch.net/blog/2017/11/24/exporting-wordpress-posts-to-markdown/

I exported the xml from my site, used pip to install Pelican to use `pelican-import` and tried the command from the post.
Problem arouse! `pelican-import` wanted pandoc installed on the system to handle the markdown conversion.
I installed it, but the version of pandoc that was installed with brew was not compatible with the version of `pelican-import`.
I found a workaround in a [Github issue](https://github.com/getpelican/pelican/issues/2322#issuecomment-384962097),
to modify the source and install it from there.

Cloned the Pelican github repo and updated `pelican/tools/pelican_import.py` as follow:

```diff
-        parse_raw = '--parse-raw' if not strip_raw else ''
-        cmd = ('pandoc --normalize {0} --from=html'
-               ' --to={1} -o "{2}" "{3}"')
+        parse_raw = '-raw_html' if not strip_raw else ''
+        cmd = ('pandoc  --from=html'
+               ' --to={1}{0} -o "{2}" "{3}"')
```

And then installed with `python3 setup.py install`.
After that, the command to convert the posts to markdown worked!

In the posts there is also parts to automatically fix the front matter in the markdown.
But since i only had 9 posts I thought it would be easier to just add and edit the parts needed by hand

## Layout, post template and post collection

I created a very basic master layout, `source/_layouts/master.blade.php`
and a template for the posts to extend `source/_layouts/post.blade.php`.
Then created a collection in the config to hold all blog posts.

```php
// config.php

return [
    'collections' => [
        'posts' => [
            'path' => '{date|Y/m}/{slug}',
            'sort' => '-date'
        ],
    ],
];
```

What this does is takes all files from the folder `source/_posts`,
sorts them on the variable `date` in the front matter
and outputs them with a path in the format `year/month/slug`.
I used this path format to match the format I used on my Wordpress site.

The posts is written in markdown, extends the post layout, that in turn extends the master layout.

After I had a working version of the blog with post I added a simple, and according to me,
elegant design with [Bulma.io](https://bulma.io).

I did all this with `yarn watch` running to get all assets auto updated,
but also the static site rebuilt and reloaded in the browser.

## Pagination of posts

On my previous wordpress blog the index page was a pagination of all the posts and I wanted similar behaviour here.
That was pretty straight forward, Jigsaw includes [pagination functionality](https://jigsaw.tighten.co/docs/collections-pagination/).
Just specify which collection and pagination count on a page and the loop over the result.

```php
---
pagination:
    collection: posts
    perPage: 3
---

// ...

@foreach ($pagination->items as $post)
    <h1 class="title">
        <a href="{{ $post->getUrl() }}">{{ $post->title }}</a>
    </h1>
    // ...
@endforeach
```

I also added a widget to the sidebar listing the latest posts.

## Deploy to Netlify

Now I hade enought of a site to deploy it for testing.
Signed up at Netlify with Github. Pushed the code to my (then private) Github repository.
And created a "New site from Git" in Netlify.

During set up of the new site a specified the build command to `yarn production`
which works similiar to the previous mentioned `yarn watch` that it builds the assets (css and js) in production mode this time
and also generated the static site. The output from the build is placed in the folder `build_production`,
that is our "Publish directory" in the set up of the site.

### Environment

From what I read, Netlify defaults to PHP version 5.6 for builds.
Jigsaw uses Laravel components that requires at least PHP 7.1.3.
We can tell Netlify which PHP version we want with the environment variable `PHP_VERSION`.
This variable can be set in the settings for a site or using the [configuration file](https://www.netlify.com/docs/netlify-toml-reference/) `netlify.toml`.
For me it is always a good idea to have "infrastructure" configuration in the same place as the code,
which means I go with the toml-file:

```toml
[build.environment]
  PHP_VERSION = "7.2"
``` 

## Custom domain name

Time to point hmazter.com at the netlify-site.

This took some fiddling around. I use AWS Route53 for DNS and ended up with this:

Name | Type | Value
-----|------|------
hmazter.com. | A | 104.198.14.52
www.hmazter.com. | CNAME | hmazter.netlify.com

When this was set and propagated trough DNS and enabled and forced HTTPS on the site with the one-click in Netlify.

Now this blog is served as static files, build with Jigsaw and hostad at Netlify.