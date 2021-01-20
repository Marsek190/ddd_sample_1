<?php

namespace Common\Service\Sitemap\Application\Service\Contract\Collector;

use Generator;

interface ProductCollectorInterface
{
    /** @return Generator */
    public function getProductCodes();
}
