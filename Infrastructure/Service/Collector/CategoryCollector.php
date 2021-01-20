<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collector;

use Phalcon\Db;
use Common\Service\Db\DbInterface;
use Common\Service\Sitemap\Application\Service\Contract\Collector\CategoryCollectorInterface;

class CategoryCollector implements CategoryCollectorInterface
{
    /** @var DbInterface */
    private $adapter;

    public function __construct(DbInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /** @inheritDoc */
    public function getCategoryIdToNameMapping()
    {
        $query = '
            SELECT DISTINCT
                category.ID   AS id,
                category.CODE AS name
            FROM b_iblock_section category
            INNER JOIN TP_CATALOG_FACET facet ON category.ID = facet.SECTION_ID
            WHERE (
                COALESCE(CHAR_LENGTH(category.CODE), 0) != 0
                AND category.ACTIVE = ?
                AND category.GLOBAL_ACTIVE = ?
                AND facet.ARCHIVE = ?
            )
            ORDER BY category.ID
        ';

        $result = $this->adapter->fetchAll($query, Db::FETCH_ASSOC, ['Y', 'Y', 0]);

        return array_column($result, 'name', 'id');
    }
}
