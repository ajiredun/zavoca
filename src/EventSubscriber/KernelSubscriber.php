<?php


namespace App\EventSubscriber;


use App\Service\ZavocaMessages;
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

    public function __construct(EntityManagerInterface $em, Security $security, SessionInterface $session, ZavocaMessages $zavocaMessages)
    {
        $this->security = $security;
        $this->em = $em;
        $this->session = $session;
        $this->zavocaMessages = $zavocaMessages;
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

        if (!is_null($user) && !$user->isActiveNow()) {
            $user->setLastactive(new \DateTime());
            $this->em->flush($user);
        }
    }

    public function onControllerInit(KernelEvent $event)
    {
        //$request = $event->getRequest();
        $this->manageZavocaMessages();
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