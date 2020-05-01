<?php


namespace Zavoca\CoreBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zavoca\CoreBundle\Event\UserTabsEvent;

class UserTabsSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            UserTabsEvent::NAME => [
                ['addRolesTab', 200],
                ['addAdvancedTab', 190]
            ]
        ];
    }

    public function addRolesTab(UserTabsEvent $event)
    {
        $event->addTab('Roles','zavoca_core_user_list',['user'=> $event->getUser()->getId()]);
    }

    public function addAdvancedTab(UserTabsEvent $event)
    {
        $event->addTab('Advanced','zavoca_core_user_list',['user'=> $event->getUser()->getId()]);
    }
}