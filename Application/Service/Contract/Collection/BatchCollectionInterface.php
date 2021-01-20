<?php

namespace Common\Service\Sitemap\Application\Service\Contract\Collection;

interface BatchCollectionInterface
{
    /**
     * @param mixed $item
     * @return array|null
     */
    public function append($item);

    /** @return array */
    public function batch();

    /** @return int */
    public function count();
}
