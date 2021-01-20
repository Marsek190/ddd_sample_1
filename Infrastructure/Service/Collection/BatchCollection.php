<?php

namespace Common\Service\Sitemap\Infrastructure\Service\Collection;

use Common\Service\Sitemap\Application\Service\Contract\Collection\BatchCollectionInterface;

class BatchCollection implements BatchCollectionInterface
{
    /** @var array */
    private $batch = [];

    /** @var int */
    private $batchCapacity;

    private $batchOffset = 0;

    /**
     * @param int $batchCapacity
     */
    public function __construct($batchCapacity)
    {
        $this->batchCapacity = $batchCapacity;
    }

    public function append($item)
    {
        $this->batch[] = $item;
        $this->batchOffset++;

        if ($this->batchOffset === $this->batchCapacity) {
            $batch = $this->batch;
            $this->batch = [];
            $this->batchOffset = 0;

            return $batch;
        }

        return null;
    }

    /** @return array */
    public function batch()
    {
        return $this->batch;
    }

    /** @return int */
    public function count()
    {
        return count($this->batch);
    }
}
