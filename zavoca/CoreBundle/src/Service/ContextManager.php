<?php


namespace Zavoca\CoreBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;

class ContextManager implements ContextManagerInterface
{
    const NATURAL = 'NATURAL';
    const CONVERSATIONAL = 'CONVERSATIONAL';
    const AJAX = 'AJAX';
    const API = 'API';

    protected $context;

    public function __construct()
    {
        $this->context = self::NATURAL;
    }

    public function defineContext(Request $request)
    {
        $path = $request->getPathInfo();

        if ($request->isXmlHttpRequest()) {
            $this->setContext(self::AJAX);
        } elseif (!is_null($path) && (strpos($path, '/api') !== false)) {
            $this->setContext(self::API);
        } elseif (!is_null($path) && (strpos($path, '/ai') !== false)) {
            $this->setContext(self::CONVERSATIONAL);
        } else {
            $this->setContext(self::NATURAL);
        }
    }

    public function setContext($context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }
}