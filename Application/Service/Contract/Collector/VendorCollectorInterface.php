<?php

namespace Common\Service\Sitemap\Application\Service\Contract\Collector;

interface VendorCollectorInterface
{
    /** @return array */
    public function getCategoryIdToVendorMapping();

    /** @return array */
    public function getVendorCodeToNameMapping();
}
