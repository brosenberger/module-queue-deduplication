# Queue DeDuplication - a Magento 2 queue deduplication enhancement

This module provides the possibility to configure topics to deduplicate messages if they haven't been processed yed

**Goals of this module:**
* avoid duplication of messages added to a Magento2 queue based on following suggestion for Java programs: https://colinchjava.github.io/2023-09-18/10-16-52-983540-rabbitmq-message-deduplication-in-java/

**Non-Goals of this module:**
* use the appropriate possibilities of an RabbitMQ plugin like https://github.com/noxdafox/rabbitmq-message-deduplication because
  * this function should work with the MySQL queue implementation from Magento as well
  * a separate plugin has to be installed with RabbitMQ and this is not always possible

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/brosenberger)

## Installation

```
composer require brocode/module-queue-deduplication
bin/magento module:enable BroCode_QueueDeDuplication
bin/magento setup:upgrade
```

## Configuration

The according deduplicated queue/topic must be configured within the file ```etc/queue_deduplication.xml```. This is a sample file that can be used:

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:brocode:module:BroCode_QueueDeDuplication:/etc/queue_deduplication.xsd">
    <topic name="brocode.image.convert"/>
</config>
```

Nothing more needs to be configured.

## Further Information

Current implementation is based on the configured Magento2-Caching strategy as it uses the internal caching mechanism for storing message ids that are scheduled within a queue. The current TTL is set to 1 day.
