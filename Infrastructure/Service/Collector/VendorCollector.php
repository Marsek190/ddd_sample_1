<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collector;

use Phalcon\Db;
use Phalcon\Db\Result\Pdo;
use Common\Service\Db\DbInterface;
use Common\Service\Sitemap\Infrastructure\Service\Collector\Helper\QueryBuilderHelperInterface;
use Common\Service\Sitemap\Application\Service\Contract\Collector\VendorCollectorInterface;

class VendorCollector implements VendorCollectorInterface
{
    /** @var DbInterface */
    private $adapter;

    /** @var QueryBuilderHelperInterface */
    private $queryBuilder;

    private $vendorIBlockId = 14;

    private $vendorPropertyId = 2436;

    public function __construct(DbInterface $adapter, QueryBuilderHelperInterface $queryBuilder)
    {
        $this->adapter = $adapter;
        $this->queryBuilder = $queryBuilder;
    }

    /** @inheritDoc */
    public function getCategoryIdToVendorMapping()
    {
        $query = '
            SELECT
	            property_enum.VALUE AS vendor_name,
	            facet.SECTION_ID    AS category_id
            FROM b_iblock_element_property element_property
            INNER JOIN b_iblock_property property ON property.ID = element_property.IBLOCK_PROPERTY_ID
                AND property.ID = ?
            INNER JOIN b_iblock_property_enum property_enum ON property_enum.ID = element_property.VALUE
                AND property_enum.PROPERTY_ID = property.ID
            INNER JOIN TP_CATALOG_FACET facet ON facet.BID = element_property.IBLOCK_ELEMENT_ID
                AND facet.ARCHIVE = ?
            ORDER BY facet.SECTION_ID, property_enum.VALUE
        ';
        /** @var Pdo $result */
        $result = $this->adapter->query($query, [$this->vendorPropertyId, 0]);
        $vendors = $this->getVendorCodeToNameMapping();

        $vendorMap = [];
        while ($row = $result->fetch(Db::FETCH_ASSOC)) {
            $categoryId = isset($row['category_id'])   ? (int) $row['category_id'] : null;
            $vendorName = isset($row['vendor_name'])   ? $row['vendor_name']       : null;
            $vendorCode = isset($vendors[$vendorName]) ? $vendors[$vendorName]     : null;

            if (!isset($vendorMap[$categoryId]) && !empty($vendorMap)) {
                yield $vendorMap;
                $vendorMap = [];
            }

            if (isset($vendorMap[$categoryId][$vendorCode]) || is_null($vendorCode)) {
                continue;
            }

            $vendorMap[$categoryId][$vendorCode] = $vendorCode;
        }

        if (!empty($vendorMap)) {
            yield $vendorMap;
        }
    }

    /** @inheritDoc */
    public function getVendorCodeToNameMapping()
    {
        $query = "
            SELECT DISTINCT
                element.NAME                    AS vendor_name,
                REPLACE(element.CODE, '-', '_') AS vendor_code
            FROM b_iblock_element element
            WHERE (
                element.IBLOCK_ID = ?
                AND element.ACTIVE = ?
                AND element.NAME IN (
                    SELECT
                        property_enum.VALUE AS vendor_name
                    FROM b_iblock_property_enum property_enum
                    WHERE ID IN (
                        SELECT
                            VALUE_ENUM AS property_enum_id
                        FROM b_iblock_element_property
                        WHERE (
                            IBLOCK_PROPERTY_ID = ?
                            AND IBLOCK_ELEMENT_ID IN (SELECT DISTINCT BID AS product_id FROM TP_CATALOG_FACET WHERE ARCHIVE = ?)
                        )
                    )
                )
            )
            ORDER BY element.NAME
        ";
        $mapping = [$this->vendorIBlockId, 'Y', $this->vendorPropertyId, 0];
        $result = $this->adapter->fetchAll($query, Db::FETCH_ASSOC, $mapping);

        return array_column($result, 'vendor_code', 'vendor_name');
    }
}
