<?php


namespace Zavoca\CoreBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;
use Zavoca\CoreBundle\Utils\PageAction;

class ContextManager implements ContextManagerInterface
{
    const NATURAL = 'NATURAL';
    const ASSISTANT = 'ASSISTANT';
    const BOT = 'BOT';
    const SEARCH = 'SEARCH';

    /**
     * @var string
     *
     * Determines the context of the request, that is natural, bot, chat and search
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

        if (!is_null($path) && (strpos($path, '/zavoca-context-bot') !== false)) {

            $this->setContext(self::BOT);

        } elseif (!is_null($path) && (strpos($path, '/zavoca-context-search') !== false)) {

            $this->setContext(self::SEARCH);

        } elseif (!is_null($path) && (strpos($path, '/zavoca-context-assistant') !== false)) {

            $this->setContext(self::ASSISTANT);

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