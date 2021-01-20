<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator;

use Common\Service\Sitemap\Application\Service\Contract\Collector\VendorCollectorInterface;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Factory\CollectionFactoryInterface;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Helper\UrlBuilderHelperInterface;

class VendorsUrlGenerator implements UrlGeneratorInterface
{
    /** @var CollectionFactoryInterface */
    private $collectionFactory;

    /** @var VendorCollectorInterface */
    private $vendorCollector;

    /** @var UrlBuilderHelperInterface */
    private $urlBuilder;

    public function __construct(
        CollectionFactoryInterface $collectionFactory,
        VendorCollectorInterface $vendorCollector,
        UrlBuilderHelperInterface $urlBuilder
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->vendorCollector = $vendorCollector;
        $this->urlBuilder = $urlBuilder;
    }

    /** @inheritDoc */
    public function generate()
    {
        $urls = $this->collectionFactory->getBatchCollection();
        foreach ($this->vendorCollector->getVendorCodeToNameMapping() as $vendorCode) {
            // страницы брендов
            if ($batch = $urls->append($this->urlBuilder->buildFromParts(['brand', $vendorCode]))) {
                yield $batch;
            }
        }

        if ($urls->count() > 0) {
            yield $urls->batch();
        }
    }
}
