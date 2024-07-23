<?php

namespace BroCode\QueueDeDuplication\Model;

use BroCode\QueueDeDuplication\Api\MessageDeDuplicationServiceRegistryInterface;
use BroCode\QueueDeDuplication\Model\Cache\Type;
use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\FrontendInterface;
use Magento\Framework\MessageQueue\MessageEncoder;

class MagentoCacheMessageDeDuplicationServiceRegistry implements MessageDeDuplicationServiceRegistryInterface
{
    /**
     * @var FrontendInterface
     */
    private FrontendInterface $cache;
    private MessageEncoder $messageEncoder;

    public function __construct(
        FrontendPool $cache,
        MessageEncoder $messageEncoder
    ) {
        $this->cache = $cache->get(Type::TYPE_IDENTIFIER);
        $this->messageEncoder = $messageEncoder;
    }

    public function checkMessages($topicName, $messages)
    {
        $cache2Message = [];
        if (!is_array($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $m) {
            $cacheId = $this->generateCacheId($topicName, $m);
            if (!$this->cache->test($cacheId)) {
                $cache2Message[$cacheId] = [
                    'id' => $cacheId,
                    'message' => $m
                ];
            }
        }
        return $cache2Message;
    }

    public function registerMessages($messages, $timeout = 86400)
    {
        foreach ($messages as $msgStruct) {
            $this->cache->save($msgStruct['id'], $msgStruct['id'], [Type::CACHE_TAG], $timeout);
        }
    }

    public function clearMessage($topicName, $message)
    {
        $this->cache->remove($this->generateCacheId($topicName, $message, false));
    }

    protected function generateCacheId($topicName, $message, $encode = true)
    {
        return md5($encode ? $this->messageEncoder->encode($topicName, $message) : $message);
    }
}
