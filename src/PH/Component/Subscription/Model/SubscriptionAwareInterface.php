<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

interface SubscriptionAwareInterface
{
    /**
     * @return SubscriptionInterface|null
     */
    public function getSubscription(): ?SubscriptionInterface;

    /**
     * @param SubscriptionInterface|null $subscription
     */
    public function setSubscription(?SubscriptionInterface $subscription): void;
}
