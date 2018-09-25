---
extends: _layouts.post
section: content

title: Using database views as tables for Laravel Eloquent
date: 2018-09-25
author: Kristoffer Högberg
slug: using-database-views-as-tables-for-laravel-eloquent
---

I found myself in a situation where I had a legacy database
which I was going to build a new Laravel application against.
The database did not have a naming convention that played nice with Laravel 
and it did include a lot of tables and columns that was not in use anymore.

After some Googling and reading about how to alias column names in Laravel, I got the idea
"How about putting a database view on the base table and use that as table for the Eloquent model".
I started with some basic benchmarking to see if it was even a viable solution. 

## Benchmarking

I did some very simple benchmarking by creating a Laravel app that had 2 model,
one directly against the database table and one against a database view containing a subset of the columns.
Filled the database with 10 000 rows and fetch with the model based on the table, the model based on the view,
using the DB facade to fetch from the table and the view.

[Here is the repository if you want to check out what i did.](https://github.com/hmazter/database-view-benchmark)

### Benchmark result
```
php artisan fetch-posts-from-view  0.50s user 0.07s system 97% cpu 0.583 total
php artisan fetch-posts-from-table  0.50s user 0.07s system 98% cpu 0.575 total
php artisan fetch-posts-from-table-query  0.16s user 0.06s system 95% cpu 0.227 total
php artisan fetch-posts-from-view-query  0.17s user 0.07s system 93% cpu 0.251 total
```

I ran those a couple of time and they gave it pretty much the same result every time.

### Performance Conclusion

Using those numbers I think my idea of using a view for the models in Laravel is okay from a performance perspective.
There are other things that has a lot of more impact then just that,
for example how the query is written, the hydration of objects, etc.

## Migrations
Since database views only live "in memory" and is not permanently created (but they do live trough server restarts),
I needed a easy way to create the views and change them over time without having to put the
whole definition in a migration file every time.

I landed in a solution where I wrote a basic artisan command that takes all files from a folder,
in this case `database/views` that I created, and creates a view with the name of the file and the
select statement described in the file.

```php
// app/Console/Commands/DbCreateViews.php

foreach ($this->filesystem->files() as $filename) {
    $viewName = str_replace('.sql', '', $filename);
    $viewContent = $this->filesystem->get($filename);

    $this->line("Creating database view $viewName");
    DB::statement("DROP VIEW IF EXISTS $viewName");
    DB::statement("CREATE VIEW $viewName AS $viewContent");
}
```

Example view file:
```sql
# posts.sql

SELECT postid          AS id,
       posttitle       AS title,
       postcategoryid  AS category_id,
       creationdate    AS created_at,
       lastupdated     AS updated_at,
       removeddate     AS deleted_at
FROM tbl_post
```

## Summary

I pretty happy with the outcome from this. It seems that its no performance overhead for the views.
Looks like Laravel has no problem using a database view for a model.
Ad it simplifies the table and column naming a lot.