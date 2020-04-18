<?php

namespace Zavoca\CoreBundle\Service;

use Zavoca\CoreBundle\Service\Interfaces\ZavocaMessagesInterface;

class ZavocaMessages implements ZavocaMessagesInterface
{
    protected $messages;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->messages = [
            'zavoca_success' => [],
            'zavoca_info' => [],
            'zavoca_error' => [],
            'zavoca_warning' => []
        ];
    }

    public function addSuccess($message)
    {
        $this->messages['zavoca_success'][]= $message;
    }

    public function addInfo($message)
    {
        $this->messages['zavoca_info'][]= $message;
    }

    public function addWarning($message)
    {
        $this->messages['zavoca_warning'][]= $message;
    }

    public function addError($message)
    {
        $this->messages['zavoca_error'][]= $message;
    }

    public function add($type, $message)
    {
        $this->messages[$type][] = $message;
    }
    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages): void
    {
        $this->messages = $messages;
    }
}