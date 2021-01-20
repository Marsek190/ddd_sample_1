<?php

namespace Common\Service\Sitemap\Application\Service\UrlHandler;

use Common\Service\Sitemap\Application\Service\UrlGenerator\ReviewsUrlGenerator;
use Common\Service\Sitemap\Application\Service\UrlGenerator\SparePartsUrlGenerator;
use Common\Service\Sitemap\Application\Service\UrlGenerator\VendorsUrlGenerator;

class UrlHandler implements UrlHandlerInterface
{
    /** @var SparePartsUrlGenerator */
    private $sparePartsUrlGenerator;

    /** @var ReviewsUrlGenerator */
    private $reviewsUrlGenerator;

    /** @var VendorsUrlGenerator */
    private $vendorsUrlGenerator;

    public function __construct(
        SparePartsUrlGenerator $sparePartsUrlGenerator,
        ReviewsUrlGenerator $reviewsUrlGenerator,
        VendorsUrlGenerator $vendorsUrlGenerator
    ) {
        $this->sparePartsUrlGenerator = $sparePartsUrlGenerator;
        $this->reviewsUrlGenerator = $reviewsUrlGenerator;
        $this->vendorsUrlGenerator = $vendorsUrlGenerator;
    }

    /** @inheritDoc */
    public function handleVendorsUrls()
    {
        return $this->vendorsUrlGenerator->generate();
    }

    /** @inheritDoc */
    public function handleReviewsUrls()
    {
        return $this->reviewsUrlGenerator->generate();
    }

    /** @inheritDoc */
    public function handleSparePartsUrls()
    {
        return $this->sparePartsUrlGenerator->generate();
    }
}
