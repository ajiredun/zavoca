<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Symfony\Component\Form\FormFactoryInterface;
use Zavoca\CoreBundle\Intent\AbstractIntent;

class GetFormTypeIntent extends AbstractIntent
{
    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getName()
    {
        "Get Form";
    }

    public function getDescription()
    {
        "Get any form and populate the form with the data(optional)";
    }

    public function execute()
    {
        $formClass = $this->get('zavoca_form_class');
        $formData = $this->get('zavoca_form_data');
        $formOptions = $this->get('zavoca_form_options');

        $form = $this->formFactory->create(
            $formClass,
            $formData === null ? [] : $formData,
            $formOptions === null ? [] : $formOptions
        );

        $this->set('zavoca_form', $form->createView());
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[
            'zavoca_form_data',
            'zavoca_form_options'
        ]);
    }

    public function inputMandatoryDefinition()
    {
        return [
            'zavoca_form_class'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'zavoca_form'
        ];
    }

}