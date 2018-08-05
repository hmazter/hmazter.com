---
extends: _layouts.post
section: content

title: Unit testing models in Laravel 5 with SQLite in Memory
date: 2015-04-02
author: hmazter
category: Developing
tags: laravel5, php, unit test
slug: unit-testing-models-in-laravel-5-with-sqlite
---

So you want to run Unit tests with PHPUnit on your [Laravel 5](http://laravel.com/)
application, and do some actual database interaction instead of mocking data?

I do that for one of my applications and I'm using SQLite with in
memory database to increase performance event more. I'll quickly show
how i have set it up.

Config and environment in Laravel 5
-----------------------------------

Laravel 5 uses the [DotEnv](https://github.com/vlucas/phpdotenv) library
for environment configuration. That means that you have .env file in the
project root, to define variables specific to your enviroment, and also
one .env in the production to specify the environment.

Your local .env file could look something like this:

```
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

It's just key-value pairs. They are used by the different config files.

The config/database.php file (rows not related to this text is removed):

```php
<?php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'testing' => [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ],
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]
    ]
];
```

As you see, the config/database.php has references to the variables in
the .env file using the env() function, with looks like env(key,
default). that functions get the corresponding value from the .env file.
And one that is particular interesting in this post is
`DB_CONNECTION`. As you saw in the .env file that was set to
*mysql*. Laravel will be using the mysql connection with the host,
database and credentials configured in the .env file.

### Testing environment

But when we run phpunit we want to use the testing connection from the
config/database.php with uses in-memory sqlite database.

This is done by setting php environment variables in the phpunit.xml
file:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit>
    ...
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="DB_CONNECTION" value="testing"/>
    </php>
</phpunit>
```

This will set the environment to testing with `APP_ENV (if you use that
in config/app.php) and also select the *testing* connection in the
database config when you run phpunit.
