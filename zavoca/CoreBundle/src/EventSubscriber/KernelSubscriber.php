<?php

namespace Zavoca\CoreBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Event\SidebarEvent;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;
use Zavoca\CoreBundle\Service\Interfaces\ZavocaMessagesInterface;
use Zavoca\CoreBundle\Service\SystemManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class KernelSubscriber implements EventSubscriberInterface
{

    protected $security;
    protected $em;
    protected $session;
    protected $zavocaMessages;
    protected $systemManager;
    protected $contextManager;
    protected $eventDispatcher;

    public function __construct(
        EntityManagerInterface $em,
        Security $security,
        SessionInterface $session,
        ZavocaMessagesInterface $zavocaMessages,
        SystemManager $systemManager,
        ContextManagerInterface $contextManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->security = $security;
        $this->em = $em;
        $this->session = $session;
        $this->zavocaMessages = $zavocaMessages;
        $this->systemManager = $systemManager;
        $this->contextManager = $contextManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onTerminate',20],
                ['onControllerInit']
            ],
            KernelEvents::RESPONSE => [
                ['onResponse']
            ]
        ];
    }

    public function onTerminate(KernelEvent $event)
    {
        $user = $this->security->getUser();

        if (!is_null($user) && $user->getAutoDarkMode()) {
            if (time() > strtotime('6 pm') && time() < strtotime('6 am')) {
                $user->setDarkTheme(true);
            } else {
                $user->setDarkTheme(false);
            }
            $this->em->flush($user);
        }

        if (!is_null($user) && !$user->isActiveNow()) {
            $user->setLastactive(new \DateTime());
            $this->em->flush($user);
        }
    }

    public function onControllerInit(KernelEvent $event)
    {
        $request = $event->getRequest();
        $this->setContextDefinition($request);
        $this->manageZavocaMessages();
        $this->setSystemAsGlobalTwig();

        $sidebarEvent = new SidebarEvent();
        $this->eventDispatcher->dispatch($sidebarEvent, SidebarEvent::NAME);

        $this->contextManager->setSidebar($sidebarEvent->getSidebar());
    }

    protected function setContextDefinition($request)
    {
        $this->contextManager->defineContext($request);
    }

    protected function setSystemAsGlobalTwig()
    {
        $this->systemManager->addTwigGlobals();
    }

    protected function manageZavocaMessages()
    {
        $flashes = $this->session->getFlashBag()->all();
        $types = array_keys($this->zavocaMessages->getMessages());

        foreach ($types as $type) {
            if (array_key_exists($type,$flashes)) {
                foreach ($flashes[$type] as $message) {
                    $this->zavocaMessages->add($type,$message);
                }
            }
        }

    }

    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response instanceof RedirectResponse) {
            //we shall add all the zavoca Messages as flash
            foreach ($this->zavocaMessages->getMessages() as $category => $values) {
                if (!empty($values)) {
                    foreach ($values as $value) {
                        $this->session->getFlashBag()->add($category, $value);
                    }
                }
            }
        }
    }

}