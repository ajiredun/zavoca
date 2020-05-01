<?php


namespace Zavoca\CoreBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Zavoca\CoreBundle\Entity\User;

class UserTabsEvent extends Event
{
    public const NAME = 'zavoca.core.event.user_tabs';

    /**
     * @var array
     */
    protected $tabs;

    /**
     * @var User
     */
    protected $user;

    protected $currentRoute;

    public function __construct(User $user, $tabs = [], $currentRoute = null)
    {
        $this->user = $user;
        $this->tabs = $tabs;
        $this->currentRoute = $currentRoute;
    }


    public function addTab($name, $route, $params)
    {
        $this->tabs[] = [
            'name' => $name,
            'route' => $route,
            'params' => $params
        ];
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * @param array $tabs
     */
    public function setTabs(array $tabs): void
    {
        $this->tabs = $tabs;
    }

    /**
     * @return mixed
     */
    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }

    /**
     * @param mixed $currentRoute
     */
    public function setCurrentRoute($currentRoute): void
    {
        $this->currentRoute = $currentRoute;
    }
}