<?php


namespace Zavoca\CoreBundle\Service\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface ContextManagerInterface
{

    public function defineContext(Request $request);

    public function setContext($context);

    public function getContext();
}