<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Zavoca\CoreBundle\Intent\AbstractIntent;

class GetFormTypeViewIntent extends AbstractIntent
{
    public function getName()
    {
        return "Form Type CreateView";
    }

    public function getDescription()
    {
        return "Calling the createView() method on the form";
    }

    public function execute()
    {
        $form = $this->get('zavoca_form');

        $this->set('zavoca_form', $form->createView());
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[]);
    }

    public function inputMandatoryDefinition()
    {
        return [
            'zavoca_form'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'zavoca_form'
        ];
    }
}