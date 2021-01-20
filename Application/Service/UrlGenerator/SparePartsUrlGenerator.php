<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator;

use Common\Service\Sitemap\Application\Service\Contract\Collector\SparePartsCollectorInterface;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Factory\CollectionFactoryInterface;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Helper\UrlBuilderHelperInterface;

class SparePartsUrlGenerator implements UrlGeneratorInterface
{
    /** @var CollectionFactoryInterface */
    private $collectionFactory;

    /** @var SparePartsCollectorInterface */
    private $sparePartsCollector;

    /** @var UrlBuilderHelperInterface */
    private $urlBuilder;

    public function __construct(
        CollectionFactoryInterface $collectionFactory,
        SparePartsCollectorInterface $sparePartsCollector,
        UrlBuilderHelperInterface $urlBuilder
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->sparePartsCollector = $sparePartsCollector;
        $this->urlBuilder = $urlBuilder;
    }

    /** @inheritDoc */
    public function generate()
    {
        $urls = $this->collectionFactory->getBatchCollection();
        /** @var string $category */
        foreach ($this->sparePartsCollector->getProductCategoryCodesBySpareParts() as $category) {
            // запасные части + категория
            if ($batch = $urls->append($this->urlBuilder->buildFromParts(['zapasnie-chasti', "filt_section-{$category}"]))) {
                yield $batch;
            }
        }
        /** @var string $vendorCode */
        foreach ($this->sparePartsCollector->getProductVendorCodesBySpareParts() as $vendorCode) {
            // запасные части + бренд
            if ($batch = $urls->append($this->urlBuilder->buildFromParts(['zapasnie-chasti', $vendorCode]))) {
                yield $batch;
            }
        }
        /** @var string $productCode */
        foreach ($this->sparePartsCollector->getProductCodesBySpareParts() as $productCode) {
            // запасные части + товары
            if ($batch = $urls->append($this->urlBuilder->buildFromParts(['zapasnie-chasti', "filt_product-{$productCode}"]))) {
                yield $batch;
            }
        }

        if ($urls->count() > 0) {
            yield $urls->batch();
        }
    }
}
