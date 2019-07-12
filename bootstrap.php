<?php

use TightenCo\Jigsaw\Jigsaw;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

$container->bind(
    Mni\FrontYAML\Markdown\MarkdownParser::class,
    App\Parsers\GitDownParser::class
);

$events->afterBuild(App\Listeners\GenerateSitemap::class);
$events->afterBuild(App\Listeners\CopyFaviconsToRoot::class);
