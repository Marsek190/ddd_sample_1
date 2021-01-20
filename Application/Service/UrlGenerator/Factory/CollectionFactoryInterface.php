<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator\Factory;

use Common\Service\Sitemap\Application\Service\Contract\Collection\BatchCollectionInterface;

interface CollectionFactoryInterface
{
    /** @return BatchCollectionInterface */
    public function getBatchCollection();
}
