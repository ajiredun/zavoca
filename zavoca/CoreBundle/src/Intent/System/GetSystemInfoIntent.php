<?php


namespace Zavoca\CoreBundle\Intent\System;


use Zavoca\CoreBundle\Intent\AbstractIntent;

class GetSystemInfoIntent extends AbstractIntent
{
    public function getName()
    {
        return "Get System Info";
    }

    public function getDescription()
    {
        return "Getting the information of the system by System ID.";
    }


    public function execute()
    {
        $this->set('system_id',6);
        $this->set('system_love', 'hello World');
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[
            'system_fields'
        ]);
    }

    public function inputMandatoryDefinition()
    {
        return [
            'system_id'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'system_love'];
    }
}