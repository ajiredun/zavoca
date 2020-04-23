<?php


namespace Zavoca\CoreBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Zavoca\CoreBundle\Flow\FlowInterface;

class FlowFactory
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getFlow($name)
    {
        $flow = $this->container->get($name);

        return $this->initFlow($flow);
    }

    /**
     * @param FlowInterface $flow
     * @return mixed
     */
    public function initFlow(FlowInterface $flow)
    {
        $flow->init($this->container);

        return $flow;
    }
}