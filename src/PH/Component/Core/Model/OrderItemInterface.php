<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Component\Order\Model\OrderItemInterface as BaseOrderItemInterface;

interface OrderItemInterface extends BaseOrderItemInterface
{
    /**
     * @return SubscriptionInterface
     */
    public function getSubscription(): SubscriptionInterface;

    /**
     * @param SubscriptionInterface $subscription
     */
    public function setSubscription(SubscriptionInterface $subscription): void;
}
