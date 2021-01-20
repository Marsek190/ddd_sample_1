<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collector\Helper;

class QueryBuilderHelper implements QueryBuilderHelperInterface
{
    /** @inheritDoc */
    public function getPlaceholdersForArray(array $data)
    {
        return implode(',', array_fill(0, count($data), '?'));
    }
}
