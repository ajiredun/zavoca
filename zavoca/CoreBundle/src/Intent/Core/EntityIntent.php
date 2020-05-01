<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Zavoca\CoreBundle\Intent\AbstractIntent;

class EntityIntent extends AbstractIntent
{
    public function getName()
    {
        return "Entity Intent";
    }

    public function getDescription()
    {
        return "Return the entity as mandatory for the flow.";
    }

    public function execute()
    {
        // do nothing
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[]);
    }

    public function inputMandatoryDefinition()
    {
        return [
          'entity'
        ];
    }

    public function outputDefinition(): array
    {
        return [
          'entity'
        ];
    }
}