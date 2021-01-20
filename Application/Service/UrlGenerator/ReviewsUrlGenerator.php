<?php

namespace Common\Service\Sitemap\Application\Service\UrlGenerator;

use Common\Service\Sitemap\Application\Service\Contract\Collector\CategoryCollectorInterface;
use Common\Service\Sitemap\Application\Service\Contract\Collector\ProductCollectorInterface;
use Common\Service\Sitemap\Application\Service\Contract\Collector\VendorCollectorInterface;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Factory\CollectionFactoryInterface;
use Common\Service\Sitemap\Application\Service\UrlGenerator\Helper\UrlBuilderHelperInterface;

class ReviewsUrlGenerator implements UrlGeneratorInterface
{
    /** @var CollectionFactoryInterface */
    private $collectionFactory;

    /** @var CategoryCollectorInterface */
    private $categoryCollector;

    /** @var ProductCollectorInterface */
    private $productCollector;

    /** @var VendorCollectorInterface */
    private $vendorCollector;

    /** @var UrlBuilderHelperInterface */
    private $urlBuilder;

    public function __construct(
        CollectionFactoryInterface $collectionFactory,
        CategoryCollectorInterface $categoryCollector,
        ProductCollectorInterface $productCollector,
        VendorCollectorInterface $vendorCollector,
        UrlBuilderHelperInterface $urlBuilder
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->categoryCollector = $categoryCollector;
        $this->productCollector = $productCollector;
        $this->vendorCollector = $vendorCollector;
        $this->urlBuilder = $urlBuilder;
    }

    /** @inheritDoc */
    public function generate()
    {
        $urls = $this->collectionFactory->getBatchCollection();
        $categories = $this->categoryCollector->getCategoryIdToNameMapping();
        /**
         * @var int $categoryId
         * @var string $category
         */
        foreach ($categories as $categoryId => $category) {
            // категория + отзывы
            if ($batch = $urls->append($this->urlBuilder->buildFromParts([$category, 'otzyvy']))) {
                yield $batch;
            }
        }

        /** @var array $vendorMap */
        foreach ($this->vendorCollector->getCategoryIdToVendorMapping() as $vendorMap) {
            $categoryId = key($vendorMap);
            if (!isset($categories[$categoryId])) {
                continue;
            }

            $category = $categories[$categoryId];

            /** @var string $vendor */
            foreach ($vendorMap[$categoryId] as $vendor) {
                // категория + отзывы + бренд
                if ($batch = $urls->append($this->urlBuilder->buildFromParts([$category, $vendor, 'otzyvy']))) {
                    yield $batch;
                }
            }
        }

        foreach ($this->productCollector->getProductCodes() as $productCode) {
            // товар + отзывы
            if ($batch = $urls->append($this->urlBuilder->buildFromParts([$productCode, 'otzyvy']))) {
                yield $batch;
            }
        }

        if ($urls->count() > 0) {
            yield $urls->batch();
        }
    }
}
