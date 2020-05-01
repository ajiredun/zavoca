<?php


namespace Zavoca\CoreBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SidebarEvent
 * @package Zavoca\CoreBundle\Event
 *
 *
 * The sidebar event, the object will be used to display the sidebar of the back office.
 * The order is of the first level elements are based on the priority of the eventSubscribers.
 *
 * Remember, the object is built dynamically, nothing is stored in the database.
 * If you want to modify a menu, make sure your event subscriber has a lower priority
 *
 *
 */
class SidebarEvent extends Event
{
    public const NAME = 'zavoca.core.event.sidebar';


    /**
     *
     * An event to build the back office sidebar
     *
     * Structure:
     *
     * it consists of a multi-level menu (3 levels) out of which, 2 are clickable
     *
     *
     *
     *
     *
     * @var array
     */
    protected $sidebar;

    public function __construct()
    {
        $this->sidebar = [];

        /*$this->sidebar = [
            [
                'code' => 'global_view',
                'name' => 'Global View',
                'child' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => '<i class="fas fa-box"></i>',
                        'route' => 'zavoca_core_main'
                    ]
                ]
            ],
            [
                'code' => 'main',
                'name' => 'MAIN',
                'child' => [
                    [
                        'name' => 'Pages',
                        'icon' => '<i class="fas fa-list"></i>',
                        'route' => 'zavoca_core_main',
                        'child' => [
                            [
                                'name' => 'View Pages',
                                'icon' => '<i class="fab fa-buffer"></i>',
                                'route' => 'zavoca_core_main'
                            ],
                            [
                                'name' => 'New Page',
                                'icon' => '<i class="fas fa-plus"></i>',
                                'route' => 'zavoca_core_main'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Users',
                        'icon' => '<i class="fas fa-users"></i>',
                        'route' => 'zavoca_core_main',
                        'child' => [
                            [
                                'name' => 'View Users',
                                'icon' => '<i class="fab fa-buffer"></i>',
                                'route' => 'zavoca_core_main'
                            ],
                            [
                                'name' => 'New User',
                                'icon' => '<i class="fas fa-user-plus"></i>',
                                'route' => 'zavoca_core_main'
                            ]
                        ]
                    ]
                ]
            ],
        ];*/
    }

    /**
     * @return array
     */
    public function getSidebar(): array
    {
        return $this->sidebar;
    }

    /**
     * @param array $sidebar
     */
    public function setSidebar(array $sidebar): void
    {
        $this->sidebar = $sidebar;
    }

    public function addInCategory($code, $menu, $nameCategoryIfNotExist = null)
    {
        $categoryExist = false;

        foreach ($this->sidebar as $categoryIndex => $category)
        {
            if ($category['code'] == $code) {
                $categoryExist = true;

                if (isset($this->sidebar[$categoryIndex]['child'])) {
                    $this->sidebar[$categoryIndex]['child'][] = $menu;
                } else {
                    $this->sidebar[$categoryIndex]['child'] = [$menu];
                }
            }
        }

        if (!$categoryExist) {
            $this->sidebar[] = [
                'code' => $code,
                'name' => is_null($nameCategoryIfNotExist)?strtoupper($code):$nameCategoryIfNotExist,
                'child' => [$menu]
            ];
        }
    }
}