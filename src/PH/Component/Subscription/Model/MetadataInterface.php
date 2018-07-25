<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface MetadataInterface extends ResourceInterface, SubscriptionAwareInterface
{
    public function getKey(): string;

    public function setKey(string $key): void;

    public function getValue(): string;

    public function setValue(string $value): void;
}
