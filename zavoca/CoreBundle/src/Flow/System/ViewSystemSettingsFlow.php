<?php


namespace Zavoca\CoreBundle\Flow\System;


use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Intent\Core\GetEntityByIdIntent;
use Zavoca\CoreBundle\Intent\Core\GetFormTypeIntent;

class ViewSystemSettingsFlow extends AbstractFlow
{
    public function getName()
    {
        return "View System Settings";
    }

    public function getDescription()
    {
        return "A flow to view system parameters.";
    }


    public function mappedParameters()
    {
        return [
            GetEntityByIdIntent::getCode() => [
                'entity_id' => 'system_id',
            ],
            GetFormTypeIntent::getCode() => [
                'zavoca_form_data' => 'entity'
            ]
        ];
    }

    public function objectsDefinition()
    {
        return [
            'Zavoca\CoreBundle\Intent\Core\GetEntityByIdIntent',
            'Zavoca\CoreBundle\Intent\Core\GetFormTypeIntent',
        ];
    }

    public function naturalPresentation()
    {
        return "natural naturalPresentation: Flow Presentation";
    }

    public function conversationPresentation()
    {
        return "natural conversationPresentation: Flow Presentation";
    }

    public function apiPresentation()
    {
        return "natural apiPresentation: Flow Presentation";
    }

    public function ajaxPresentation()
    {
        return "natural ajaxPresentation: Flow Presentation";
    }

}