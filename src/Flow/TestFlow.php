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
}