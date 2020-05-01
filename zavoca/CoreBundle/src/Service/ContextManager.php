<?php


namespace Zavoca\CoreBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;
use Zavoca\CoreBundle\Utils\PageAction;

class ContextManager implements ContextManagerInterface
{
    const NATURAL = 'NATURAL';
    const CONVERSATIONAL = 'CONVERSATIONAL';
    const AJAX = 'AJAX';
    const API = 'API';

    /**
     * @var string
     *
     * Determines the context of the request, that is natural, conversational, ajax ans api
     */
    protected $context;

    protected $sidebar;

    protected $pageActions;

    protected $pageTitle;


    public function __construct()
    {
        $this->context = self::NATURAL;
        $this->sidebar = [];
        $this->pageActions = [];
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

    /**
     * @return array
     */
    public function getSidebar(): array
    {
        return $this->sidebar;
    }

    /**
     * @param array $sidebar
     */
    public function setSidebar(array $sidebar): void
    {
        $this->sidebar = $sidebar;
    }

    /**
     * @param PageAction $pageAction
     */
    public function addPageAction(PageAction $pageAction)
    {
        $this->pageActions[] = $pageAction;
    }

    /**
     * @return array
     */
    public function getPageActions(): array
    {
        return $this->pageActions;
    }

    /**
     * @param array $pageActions
     */
    public function setPageActions(array $pageActions): void
    {
        $this->pageActions = $pageActions;
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param mixed $pageTitle
     */
    public function setPageTitle($pageTitle): void
    {
        $this->pageTitle = $pageTitle;
    }
}