<?php


namespace Zavoca\CoreBundle\Flow\User;


use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Intent\User\UserTabsIntent;

class UserTabsFlow extends AbstractFlow
{
    public function getName()
    {
        return "Admin User Tabs";
    }

    public function getDescription()
    {
        return "Getting all the tabs to display on the user details page.";
    }

    public function objectsDefinition()
    {
        return [
            UserTabsIntent::class
        ];
    }

    public function naturalPresentation()
    {
        return $this->render('zavoca\core\flow\user\user_tabs.html.twig');
    }

    public function conversationPresentation()
    {
        return null;
    }
}