<?php

namespace BroCode\QueueDeDuplication\Model;

use BroCode\QueueDeDuplication\Api\Constants;
use Magento\Framework\Config\DataInterface;

class QueueDeDuplicationConfigService
{
    /**
     * @var DataInterface
     */
    private DataInterface $configStorage;

    /**
     * @param DataInterface $configStorage
     */
    public function __construct(DataInterface $configStorage)
    {
        $this->configStorage = $configStorage;
    }

    public function needsDeDuplication(string $topicName): bool
    {
        $topics = $this->configStorage->get(Constants::CONFIG_KEY_NAME);

        if (!$topics) {
            return false;
        }

        return isset($topics[$topicName]) && $topics[$topicName][Constants::DISABLED] === false;
    }
}
