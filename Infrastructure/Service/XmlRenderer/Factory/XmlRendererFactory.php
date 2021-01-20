<?php

namespace Common\Service\Sitemap\Infrastructure\Service\XmlRenderer\Factory;

use Common\Base\Di\Container;
use Phalcon\Mvc\ViewBaseInterface;

class XmlRendererFactory
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getInstance()
    {
        return $this->container->get(ViewBaseInterface::class, ['viewsDir' => APP_PATH . '/views/sitemap/']);
    }
}
