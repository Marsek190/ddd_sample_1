<?php

namespace Common\Service\Sitemap\Application\Service\UrlHandler;

use Generator;

interface UrlHandlerInterface
{
    /** @return Generator */
    public function handleVendorsUrls();

    /** @return Generator */
    public function handleReviewsUrls();

    /** @return Generator */
    public function handleSparePartsUrls();
}
