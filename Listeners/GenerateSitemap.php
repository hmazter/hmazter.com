<?php
declare(strict_types=1);

namespace App\Listeners;

use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class GenerateSitemap
{
    private $ignore = ['404.html'];

    public function handle(Jigsaw $jigsaw)
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');
        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');

        collect($jigsaw->getOutputPaths())->each(function ($path) use ($baseUrl, $sitemap) {
            if ($this->isAsset($path) || $this->shouldIgnore($path)) {
                return;
            }

            $sitemap->addItem($baseUrl . $path, time());
        });

        $sitemap->write();
    }

    private function shouldIgnore($path)
    {
        return in_array($path, $this->ignore);
    }

    private function isAsset($path)
    {
        return starts_with($path, '/assets');
    }
}