<?php


namespace Zavoca\CoreBundle\Service\Interfaces;


use Symfony\Component\HttpFoundation\Request;
use Zavoca\CoreBundle\Utils\PageAction;

interface ContextManagerInterface
{

    public function defineContext(Request $request);

    public function setContext($context);

    public function getContext();

    public function setSidebar(array $sidebar);

    public function getSidebar();

    public function getPageTitle();

    public function setPageTitle($pageTitle);

    public function addPageAction(PageAction $pageAction);

    public function getPageActions();

    public function setPageActions(array $pageActions);
}