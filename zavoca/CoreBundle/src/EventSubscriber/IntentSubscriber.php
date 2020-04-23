<?php


namespace Zavoca\CoreBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zavoca\CoreBundle\Event\FlowEvent;
use Zavoca\CoreBundle\Event\IntentEvent;

class IntentSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            IntentEvent::NAME => [
                ['intentEvent']
            ]
        ];
    }

    public function intentEvent(IntentEvent $event)
    {

        // $event->getIntent()->getType()
    }

}