<?php


namespace Zavoca\CoreBundle\Flow\User;


use Zavoca\CoreBundle\Enums\Roles;
use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Intent\Core\GetFormTypeIntent;
use Zavoca\CoreBundle\Intent\Core\GetFormTypeViewIntent;
use Zavoca\CoreBundle\Intent\Core\HandleFormTypeIntent;

class UserDetailsFlow extends AbstractFlow
{
    public function getName()
    {
        return "User Details Form";
    }

    public function getDescription()
    {
        return "Basic user details form";
    }

    public function mappedParameters()
    {
        return [
            GetFormTypeIntent::getCode() => [
                'zavoca_form_entity' => 'user',
                'zavoca_form' => 'user_form'
            ],
            HandleFormTypeIntent::getCode() => [
                'zavoca_form_entity' => 'user',
                'zavoca_form' => 'user_form'
            ],
            GetFormTypeViewIntent::getCode() => [
                'zavoca_form' => 'user_form'
            ],
        ];
    }

    public function objectsDefinition()
    {
        return [
            GetFormTypeIntent::class,
            HandleFormTypeIntent::class,
            GetFormTypeViewIntent::class
        ];
    }

    public function defaultInputs()
    {
        return [
            'zavoca_form_access' => Roles::ROLE_USER_MANAGEMENT_EDITOR
        ];
    }

    public function naturalPresentation()
    {
        return $this->render('zavoca\core\flow\user\user_details.html.twig');
    }

}