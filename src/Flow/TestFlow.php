<?php


namespace App\Flow;


use Zavoca\CoreBundle\Flow\AbstractFlow;

class TestFlow extends AbstractFlow
{
    public function getName()
    {
        return "Test Flow";
    }

    public function getDescription()
    {
        return "A description test";
    }

    public function objectsDefinition()
    {
        // TODO: Implement intentsDefinition() method.
    }

    public function naturalPresentation()
    {
        // TODO: Implement naturalPresentation() method.
    }

    public function conversationPresentation()
    {
        // TODO: Implement conversationPresentation() method.
    }

    public function apiPresentation()
    {
        // TODO: Implement apiPresentation() method.
    }

    public function ajaxPresentation()
    {
        // TODO: Implement ajaxPresentation() method.
    }
}