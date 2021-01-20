<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collection\Factory;

use Common\Service\Sitemap\Infrastructure\Service\Collection\BatchCollection;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Factory\CollectionFactoryInterface;

class CollectionFactory implements CollectionFactoryInterface
{
    /** @inheritDoc */
    public function getBatchCollection()
    {
        return new BatchCollection(25000);
    }
}
