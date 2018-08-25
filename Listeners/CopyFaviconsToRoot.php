<?php
declare(strict_types=1);

namespace App\Listeners;

use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class CopyFaviconsToRoot
{
    public function handle(Jigsaw $jigsaw)
    {
        $sourcePath = $jigsaw->getSourcePath() .'/_assets/favicon/';
        $destinationPath = $jigsaw->getDestinationPath();

        $files = glob($sourcePath . '*');
        foreach ($files as $file) {
            copy($file, $destinationPath . '/' . basename($file));
        }
    }
}