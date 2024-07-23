<?php

namespace BroCode\QueueDeDuplication\Config;

use BroCode\QueueDeDuplication\Api\Constants;
use Magento\Framework\Config\Dom\UrnResolver;
use Magento\Framework\Config\SchemaLocatorInterface;

class SchemaLocator implements SchemaLocatorInterface
{

    /**
     * @var UrnResolver
     */
    private UrnResolver $urnResolver;

    public function __construct(UrnResolver $urnResolver)
    {
        $this->urnResolver = $urnResolver;
    }

    /**
     * @inheritDoc
     */
    public function getSchema()
    {
        return $this->urnResolver->getRealPath(Constants::XSD_FILE_URN);
    }

    /**
     * @inheritDoc
     */
    public function getPerFileSchema()
    {
        return $this->urnResolver->getRealPath(Constants::XSD_FILE_URN);
    }
}
