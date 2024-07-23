<?php

namespace BroCode\QueueDeDuplication\Plugin;

use BroCode\QueueDeDuplication\Api\MessageDeDuplicationServiceRegistryInterface;
use BroCode\QueueDeDuplication\Model\QueueDeDuplicationConfigService;
use Magento\Framework\MessageQueue\PublisherInterface;

class PublisherDeDuplicationPlugin
{
    private QueueDeDuplicationConfigService $configService;
    private MessageDeDuplicationServiceRegistryInterface $messageServiceRegistry;

    /**
     * @param QueueDeDuplicationConfigService $configService
     * @param MessageDeDuplicationServiceRegistryInterface $messageServiceRegistry
     */
    public function __construct(
        QueueDeDuplicationConfigService $configService,
        MessageDeDuplicationServiceRegistryInterface $messageServiceRegistry
    ) {
        $this->configService = $configService;
        $this->messageServiceRegistry = $messageServiceRegistry;
    }

    public function aroundPublish(PublisherInterface $subject, callable $proceed, string $topicName, mixed $messages)
    {
        if ($this->configService->needsDeDuplication($topicName)) {
            $nonDuplicatedMessages = $this->messageServiceRegistry->checkMessages($topicName, $messages);
            foreach ($nonDuplicatedMessages as $msgStruct) {
                $returnValue = $proceed($topicName, $msgStruct['message']);
            }
            $this->messageServiceRegistry->registerMessages($nonDuplicatedMessages, 86400);
        } else {
            $returnValue = $proceed($topicName, $messages);
        }

        return $returnValue;
    }
}
