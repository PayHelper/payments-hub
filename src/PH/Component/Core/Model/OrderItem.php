<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Component\Order\Model\OrderItem as BaseOrderItem;

class OrderItem extends BaseOrderItem implements OrderItemInterface
{
    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * {@inheritdoc}
     */
    public function getSubscription(): SubscriptionInterface
    {
        return $this->subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubscription(SubscriptionInterface $subscription): void
    {
        $this->subscription = $subscription;
    }
}
