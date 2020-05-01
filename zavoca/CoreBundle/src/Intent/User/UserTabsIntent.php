<?php


namespace Zavoca\CoreBundle\Intent\User;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Zavoca\CoreBundle\Event\UserTabsEvent;
use Zavoca\CoreBundle\Intent\AbstractIntent;
use Zavoca\CoreBundle\Service\ContextManager;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;
use Zavoca\CoreBundle\Service\Interfaces\ControlManagerInterface;

class UserTabsIntent extends AbstractIntent
{

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ContextManagerInterface
     */
    protected $contextManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, ContextManagerInterface $contextManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->contextManager = $contextManager;
    }

    public function getName()
    {
        return "User Tabs";
    }

    public function getDescription()
    {
        return "Returns a list of tabs for the user details page along with their respective URLs";
    }

    public function execute()
    {

        $currentRoute = null;
        if ($this->contextManager->getContext() == ContextManager::NATURAL && !is_null($this->get('request'))) {
            $request = $this->get('request');
            $currentRoute = $request->get('_route');
        }

        $user = $this->get('user');
        $userId = $user->getId();


        $userTabs = [
            [
                'name' => 'Details',
                'route' => 'zavoca_core_user_profile',
                'params' => ['user'=> $userId]
            ]
        ];

        $event = new UserTabsEvent($user, $userTabs, $currentRoute);
        $this->eventDispatcher->dispatch($event, UserTabsEvent::NAME);

        $this->set('user_tabs',$event->getTabs());
        $this->set('user_tabs_active', $event->getCurrentRoute());
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),['request']);
    }

    public function inputMandatoryDefinition()
    {
        return [
            'user'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'user_tabs',
            'user_tabs_active'
        ];
    }

}