<?php


namespace Zavoca\CoreBundle\Flow\User;


use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Intent\Core\EntityCreatedParticularMonthIntent;

class UsersCreatedPerMonthFlow extends AbstractFlow
{
    public function getName()
    {
        return "Users created per month";
    }

    public function getDescription()
    {
        return "Users that have been created for a particular month, default is this current month. For previous month, it is -1.";
    }

    public function objectsDefinition()
    {
        return [
            EntityCreatedParticularMonthIntent::class
        ];
    }

    public function defaultInputs()
    {
        return [
            'zavoca_list_month' => 0,
            'zavoca_list_entity_class' => User::class,
            'zavoca_list_lazy' => true,
            'zavoca_list_description' => 'Users created on'
        ];
    }

    public function isValid()
    {
        $isValid = parent::isValid();

        if ($this->get('zavoca_list_month') > 0) {
            $isValid = false;
        }

        return $isValid;
    }

    public function naturalPresentation()
    {
        return $this->render('zavoca\core\flow\user\user_list.html.twig');
    }
}