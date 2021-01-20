<?php

namespace Common\Service\Sitemap\Application\Service\Contract\Collector;

interface CategoryCollectorInterface
{
    /** @return array */
    public function getCategoryIdToNameMapping();
}
