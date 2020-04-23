<?php


namespace Zavoca\CoreBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;
use Zavoca\CoreBundle\Flow\FlowInterface;

class FlowEvent extends Event
{
    public const NAME = 'zavoca.core.event.flow';

    const INIT = 'flow.event.init';
    const BEFORE_INPUT_VALIDATION = 'flow.event.before_input_validation';
    const BEFORE_EXECUTE = 'flow.event.before_execute';
    const AFTER_EXECUTE = 'flow.event.after_execute';
    const ERROR = 'flow.event.error';
    const PRESENTATION = 'flow.event.presentation';

    /**
     * @var FlowInterface
     */
    protected $flow;

    protected $type;

    public function __construct(FlowInterface $flow, $type)
    {
        $this->flow = $flow;
        $this->type = $type;
    }

    /**
     * @return FlowInterface
     */
    public function getFlow(): FlowInterface
    {
        return $this->flow;
    }

    /**
     * @param FlowInterface $flow
     */
    public function setFlow(FlowInterface $flow): void
    {
        $this->flow = $flow;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
}