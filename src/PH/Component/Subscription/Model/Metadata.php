<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

class Metadata implements MetadataInterface
{
    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function getSubscription(): ?SubscriptionInterface
    {
        return $this->subscription;
    }

    public function setSubscription(?SubscriptionInterface $subscription): void
    {
        $this->subscription = $subscription;
    }
}
