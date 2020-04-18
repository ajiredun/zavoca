<?php

namespace Zavoca\CoreBundle\Service\Interfaces;

interface ZavocaMessagesInterface
{
    public function init();

    public function addSuccess($message);

    public function addInfo($message);

    public function addWarning($message);

    public function addError($message);

    public function add($type, $message);
    /**
     * @return array
     */
    public function getMessages();

    /**
     * @param mixed $messages
     */
    public function setMessages($messages);
}