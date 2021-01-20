<?php

namespace Common\Service\Sitemap\Application\Service\Contract\Collector;

interface SparePartsCollectorInterface
{
    /** @return array */
    public function getProductCategoryCodesBySpareParts();

    /** @return array */
    public function getProductVendorCodesBySpareParts();

    /** @return array */
    public function getProductCodesBySpareParts();
}
