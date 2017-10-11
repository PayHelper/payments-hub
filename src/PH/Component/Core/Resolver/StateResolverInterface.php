<?php

declare(strict_types=1);

namespace PH\Component\Core\Resolver;

use PH\Component\Core\Model\SubscriptionInterface;

interface StateResolverInterface
{
    /**
     * @param SubscriptionInterface $subscription
     */
    public function resolve(SubscriptionInterface $subscription);
}
