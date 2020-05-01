<?php


namespace Zavoca\CoreBundle\Flow\User;


use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Flow\System\ChangeSystemSettingsFlow;
use Zavoca\CoreBundle\Intent\Core\EntityIntent;
use Zavoca\CoreBundle\Intent\User\GetUserByIdIntent;

class WidgetUserFlow extends AbstractFlow
{
    public function getName()
    {
        return "Widget User";
    }

    public function getDescription()
    {
        return "Return the relevant information about the user";
    }

    public function mappedParameters()
    {
        return [
          EntityIntent::getCode() => [
              'entity' => 'user'
          ]
        ];
    }

    public function objectsDefinition()
    {
        return [
            EntityIntent::class,
        ];
    }

    public function naturalPresentation()
    {
        return $this->render('zavoca\core\flow\user\view_user.html.twig');
    }

    public function conversationPresentation()
    {
        /**
         * @var User $user
         */
        $user = $this->get('user');
        $id = $user->getId();
        $name = $user->getName();
        $address = $user->getAddress();
        $mobileNumber = $user->getMobile();
        $telephoneNumber = $user->getTelephone();


        $ret = "The user ID is $id and name is $name .";
        if (!is_null($address)) {
            $ret .= " Stays at $address .";
        }

        $ret .= " Mobile number is $mobileNumber";

        if (!is_null($telephoneNumber)) {
            $ret .= " and telephone number is $telephoneNumber";
        }

        return $ret;
    }

}