<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator\Helper;

interface UrlBuilderHelperInterface
{
    /**
     * @param array $parts
     * @return string
     */
    public function buildFromParts(array $parts);
}
