<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collector;

use Phalcon\Db;
use Common\Service\Db\DbInterface;
use Phalcon\Db\Result\Pdo;
use Common\Service\Sitemap\Application\Service\Contract\Collector\ProductCollectorInterface;

class ProductCollector implements ProductCollectorInterface
{
    /** @var DbInterface */
    private $adapter;

    public function __construct(DbInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /** @inheritDoc */
    public function getProductCodes()
    {
        $query = '
            SELECT DISTINCT element.CODE
            FROM b_iblock_element element
            INNER JOIN TP_CATALOG_FACET facet ON element.ID = facet.BID
        ';

        /** @var Pdo $result */
        $result = $this->adapter->query($query);
        while ($productCode = $result->fetch(Db::FETCH_COLUMN)) {
            yield $productCode;
        }
    }
}
