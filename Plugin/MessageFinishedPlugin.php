<?php

namespace BroCode\QueueDeDuplication\Plugin;

use BroCode\QueueDeDuplication\Api\MessageDeDuplicationServiceRegistryInterface;
use Magento\Framework\MessageQueue\EnvelopeInterface;

class MessageFinishedPlugin
{

    private MessageDeDuplicationServiceRegistryInterface $messageServiceRegistry;

    public function __construct(MessageDeDuplicationServiceRegistryInterface $messageServiceRegistry)
    {
        $this->messageServiceRegistry = $messageServiceRegistry;
    }

    public function afterAcknowledge($subject, $result, EnvelopeInterface $envelope)
    {
        $this->handleMessageCacheEntry($envelope);
        return $result;
    }

    public function afterReject($subject, $result, EnvelopeInterface $envelope, $requeue, $rejectionMessage) {
        if (!$requeue) {
            $this->handleMessageCacheEntry($envelope);
        }
    }

    protected function handleMessageCacheEntry(EnvelopeInterface $envelope) {
        $this->messageServiceRegistry->clearMessage($envelope->getProperties()['topic_name'], $envelope->getBody());
    }
}
