<?php

namespace BroCode\QueueDeDuplication\Api;

interface MessageDeDuplicationServiceRegistryInterface
{
    public function checkMessages($topicName, $messages);

    public function registerMessages($messages, $timeout = 0);

    public function clearMessage($topicName, $message);
}
