<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator;

use Generator;

interface UrlGeneratorInterface
{
    /** @return Generator */
    public function generate();
}
