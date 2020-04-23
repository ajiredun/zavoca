<?php


namespace Zavoca\CoreBundle\Flow\System;


use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Intent\System\GetSystemInfoIntent;

class ChangeSystemSettingsFlow extends AbstractFlow
{
    public function getName()
    {
        return "Change System Settings Flow";
    }

    public function getDescription()
    {
        return "A flow to configure system parameters.";
    }

    public function objectsDefinition()
    {
        return [
            'Zavoca\CoreBundle\Intent\System\GetSystemInfoIntent',
            'Zavoca\CoreBundle\Flow\System\ViewSystemSettingsFlow'
        ];
    }

    public function naturalPresentation()
    {
        return $this->render('zavoca\core\flow\change_system_settings.html.twig', ['flow'=>$this->getOutput()->getParameters()]);
    }

    public function conversationPresentation()
    {
        return "conversation: Flow Presentation";
    }

    public function apiPresentation()
    {
        return "api: Flow Presentation";
    }

    public function ajaxPresentation()
    {
        return "ajax: Flow Presentation";
    }

}