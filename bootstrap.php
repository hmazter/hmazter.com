<?php

use TightenCo\Jigsaw\Jigsaw;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

$events->afterBuild(App\Listeners\GenerateSitemap::class);
$events->afterBuild(App\Listeners\CopyFaviconsToRoot::class);
