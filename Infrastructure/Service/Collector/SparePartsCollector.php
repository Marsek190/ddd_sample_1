<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collector;

use Phalcon\Db;
use Common\Service\Db\DbInterface;
use Common\Service\Sitemap\Application\Service\Contract\Collector\SparePartsCollectorInterface;

class SparePartsCollector implements SparePartsCollectorInterface
{
    /** @var DbInterface */
    private $adapter;

    public function __construct(DbInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /** @inheritDoc */
    public function getProductCategoryCodesBySpareParts()
    {
        $query = 'SELECT section_code AS category FROM tp_cache_spare_parts GROUP BY section_code';
        $result = $this->adapter->fetchAll($query, Db::FETCH_ASSOC);

        return array_column($result, 'category');
    }

    /** @inheritDoc */
    public function getProductVendorCodesBySpareParts()
    {
        $query = 'SELECT brand_code AS vendor_code FROM tp_cache_spare_parts GROUP BY vendor_code';
        $result = $this->adapter->fetchAll($query, Db::FETCH_ASSOC);

        return array_column($result, 'vendor_code');
    }

    /** @inheritDoc */
    public function getProductCodesBySpareParts()
    {
        $query = 'SELECT product_code FROM tp_cache_spare_parts GROUP BY product_id';
        $result = $this->adapter->fetchAll($query, Db::FETCH_ASSOC);

        return array_column($result, 'product_code');
    }
}
