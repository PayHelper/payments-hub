<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

class SubscriptionItem implements SubscriptionItemInterface
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * @var int
     */
    protected $unitPrice = 0;

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscription(): ?SubscriptionInterface
    {
        return $this->subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubscription(?SubscriptionInterface $subscription): void
    {
        $this->subscription = $subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnitPrice(int $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }
}
