<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Security;
use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Intent\AbstractIntent;

class GetFormTypeIntent extends AbstractIntent
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var Security
     */
    protected $security;

    public function __construct(FormFactoryInterface $formFactory, Security $security)
    {
        $this->formFactory = $formFactory;
        $this->security = $security;
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
        $formData = $this->get('zavoca_form_entity');
        $formOptions = $this->get('zavoca_form_options');

        $editable = true;
        $formAccess = $this->get('zavoca_form_access');
        if ($formAccess) {
            // need to check access for editing else, disable mode
            $editable = $this->security->isGranted($formAccess, $formData);
        }

        if ($formOptions === null) {
            $formOptions = [
                'attr' => ['class' => 'form-horizontal form-material  r-separator'],
                'editable' => $editable
            ];
        } else {
            $formOptions = array_merge($formOptions,['editable'=>$editable]);
        }

        $form = $this->formFactory->create(
            $formClass,
            $formData === null ? [] : $formData,
            $formOptions
        );

        $this->set('zavoca_form', $form);
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[
            'zavoca_form_entity',
            'zavoca_form_options',
            'zavoca_form_access'
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