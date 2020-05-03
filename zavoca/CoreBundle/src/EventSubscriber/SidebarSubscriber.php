<?php


namespace Zavoca\CoreBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zavoca\CoreBundle\Event\SidebarEvent;

class SidebarSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            SidebarEvent::NAME => [
                ['addGlobalView', 200],
                ['addMainSidebar', 190],
                ['addSystemSidebar',10]
            ]
        ];
    }

    public function addGlobalView(SidebarEvent $event)
    {

        $menu = [
            'name' => 'Dashboard',
            'icon' => '<i class="fas fa-box"></i>',
            'route' => 'zavoca_core_main'
        ];

        $event->addInCategory('global_view',$menu,'Global View');
    }

    public function addMainSidebar(SidebarEvent $event)
    {
        $menuPages = [
            'name' => 'Pages',
            'icon' => '<i class="fas fa-list"></i>',
            'child' => [
                [
                    'name' => 'View Pages',
                    'icon' => '<i class="fab fa-buffer"></i>',
                    'route' => 'zavoca_core_test'
                ],
                [
                    'name' => 'New Page',
                    'icon' => '<i class="fas fa-plus"></i>',
                    'route' => 'zavoca_core_test'
                ]
            ]
        ];
        $menuUsers = [
            'name' => 'Users',
            'icon' => '<i class="fas fa-users"></i>',
            'child' => [
                [
                    'name' => 'View Users',
                    'icon' => '<i class="fab fa-buffer"></i>',
                    'route' => 'zavoca_core_user_list'
                ],
                [
                    'name' => 'New User',
                    'icon' => '<i class="fas fa-user-plus"></i>',
                    'route' => 'zavoca_core_user_list'
                ]
            ]
        ];

        $event->addInCategory('main',$menuPages,'Main');
        $event->addInCategory('main',$menuUsers);
    }

    public function addSystemSidebar(SidebarEvent $event)
    {
        $systemMenu = [
            'name' => 'System Configuration',
            'icon' => '<i class="fas fa-cogs"></i>',
            'route' => 'zavoca_core_test_pac'
        ];

        $event->addInCategory('system',$systemMenu,'System');
    }
}