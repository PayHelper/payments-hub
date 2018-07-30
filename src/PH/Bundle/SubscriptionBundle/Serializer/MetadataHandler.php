<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Serializer;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use PH\Component\Subscription\Model\MetadataInterface;

final class MetadataHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => MetadataInterface::class,
                'method' => 'serializeToJson',
            ],
        ];
    }

    public function serializeToJson(JsonSerializationVisitor $visitor, Collection $metadata)
    {
        $result = [];

        foreach ((array) $metadata->toArray() as $item) {
            $result[$item->getKey()] = $item->getValue();
        }

        return $result;
    }
}
