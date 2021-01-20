<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator\Helper;

class UrlBuilderHelper implements UrlBuilderHelperInterface
{
    /** @inheritDoc */
    public function buildFromParts(array $parts)
    {
        $parts = array_filter($parts, function ($part) { return !empty($part); });
        $format = implode('/', array_fill(0, count($parts), '%s'));

        return '/' . sprintf($format, ...$parts) . '/';
    }
}
