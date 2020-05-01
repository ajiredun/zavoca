<?php


namespace Zavoca\CoreBundle\Service\Interfaces;

use Zavoca\CoreBundle\Flow\FlowInterface;

interface ControlManagerInterface
{


    public function execute(FlowInterface $flow, $input = [], $returnParameterBag = false, $developmentCheckInputParameters = false);

    public function handleError(FlowInterface $flow, $exception);

    public function handlePresentation(FlowInterface $flow);
}