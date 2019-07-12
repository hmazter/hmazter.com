<?php

namespace App\Parsers;

use GitDown\GitDown;
use TightenCo\Jigsaw\Parsers\MarkdownParser;

class GitDownParser extends MarkdownParser
{
    /**
     * Set GitDown as parser
     *
     * @return void
     */
    public function __construct()
    {
        $this->parser = new GitDown(
            getenv('GITHUB_TOKEN'),
            'hmazter/hmazter.com'
        );
    }
}