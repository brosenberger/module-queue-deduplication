<?php

namespace BroCode\QueueDeDuplication\Config;

use BroCode\QueueDeDuplication\Api\Constants;
use Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{

    /**
     * @inheritDoc
     */
    public function convert($source)
    {
        $topics = [];

        foreach ($source->getElementsByTagName('topic') as $topicNode) {
            $topicAttributes = $topicNode->attributes;
            $topicName = $topicAttributes->getNamedItem('name')?->nodeValue;
            $disabled = (boolean)$topicAttributes->getNamedItem('disabled')?->nodeValue;

            $topics[$topicName] = [
                Constants::TOPIC_NAME => $topicName,
                Constants::DISABLED => $disabled,
            ];
        }

        return [ Constants::CONFIG_KEY_NAME => $topics ];
    }
}
