<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collector\Helper;

interface QueryBuilderHelperInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function getPlaceholdersForArray(array $data);
}
