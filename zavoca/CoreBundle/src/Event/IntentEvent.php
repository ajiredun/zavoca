<?php


namespace Zavoca\CoreBundle\Event;



use Symfony\Contracts\EventDispatcher\Event;
use Zavoca\CoreBundle\Intent\IntentInterface;

class IntentEvent extends Event
{
    public const NAME = 'zavoca.core.event.intent';

    const INIT = 'intent.event.init';
    const BEFORE_INPUT_VALIDATION = 'intent.event.before_input_validation';
    const BEFORE_EXECUTE = 'intent.event.before_execute';
    const AFTER_EXECUTE = 'intent.event.after_execute';
    const ERROR = 'intent.event.error';
    const WRAP_UP = 'intent.event.wrap_up';


    /**
     * @var IntentInterface
     */
    protected $intent;

    protected $type;

    public function __construct(IntentInterface $intent, $type)
    {
        $this->intent = $intent;
        $this->type = $type;
    }

    /**
     * @return IntentInterface
     */
    public function getIntent(): IntentInterface
    {
        return $this->intent;
    }

    /**
     * @param IntentInterface $intent
     */
    public function setIntent(IntentInterface $intent): void
    {
        $this->intent = $intent;
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