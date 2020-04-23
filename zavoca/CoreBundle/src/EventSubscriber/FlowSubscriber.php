<?php


namespace Zavoca\CoreBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zavoca\CoreBundle\Event\FlowEvent;

class FlowSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FlowEvent::NAME => [
                ['flowEvent']
            ]
        ];
    }

    public function flowEvent(FlowEvent $event)
    {

        // $event->getFlow()->getType()
    }

}