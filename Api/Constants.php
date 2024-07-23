<?php

namespace BroCode\QueueDeDuplication\Api;

class Constants
{
    public const CONFIG_KEY_NAME = 'queue_deduplication_topics';
    public const CACHE_KEY = 'queue_deduplication_config';
    public const FILE_NAME = 'queue_deduplication.xml';
    public const TOPIC_NAME = 'topic_name';
    public const DISABLED = 'disabled';
    public const XSD_FILE_URN = 'urn:brocode:module:BroCode_QueueDeDuplication:/etc/queue_deduplication.xsd';
}
