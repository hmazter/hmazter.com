---
extends: _layouts.post
section: content

title: Speeding up PHP Docker with OpCache
date: 2019-04-02
author: Kristoffer Högberg
slug: speeding-up-php-docker-with-opcache
---

After spending some time trying to figure out why my PHP Application was so much slower
running in Docker locally then running directly with PHP-FPM on my machine.
I finally realized that the base Docker image I was using did not have OpCache installed which I'm used to it is with local PHP.
I was using the [Official PHP image based on Alpine Linux with PHP-FPM](https://hub.docker.com/_/php)

## Installing OpCache

It's a single step required to install OpCache in the image. Using the following line in your Dockerfile

```dockerfile
# Dockerfile
RUN docker-php-ext-install opcache
```

## Tweaking OpCache settings
I wanted to tweak the settings for OpCache to both allow for more files in the cache, since Laravel and Symfony's
vendor directories can grow quite large. And also disable the re-validation of files in production.

To do that I wrote a `opcache.ini` file that I included in the image.
The file includes a environment variable to enable validation of files for local development.

```dockerfile
# Dockerfile
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"
ADD opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"
```

```ini
# opcache.ini
[opcache]

; maximum memory that OPcache can use to store compiled PHP files, Symfony recommends 256
opcache.memory_consumption=192

; maximum number of files that can be stored in the cache
opcache.max_accelerated_files=20000

; validate on every request
opcache.revalidate_freq=0

; re-validate of timestamps, is set to false (0) by default, is overridden in local docker-compose
opcache.validate_timestamps=${PHP_OPCACHE_VALIDATE_TIMESTAMPS}

opcache.interned_strings_buffer=16

opcache.fast_shutdown=1

```

When running `docker-compose` locally i include the environment variable `PHP_OPCACHE_VALIDATE_TIMESTAMPS: 1` for my app container.

```yaml
# docker-compose.yml
services:
  app:
    environment:
      PHP_OPCACHE_VALIDATE_TIMESTAMPS: 1
```