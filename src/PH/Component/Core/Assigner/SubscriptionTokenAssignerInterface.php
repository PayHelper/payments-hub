<?php

declare(strict_types=1);

namespace PH\Component\Core\Assigner;

use PH\Component\Core\Model\SubscriptionInterface;

interface SubscriptionTokenAssignerInterface
{
    /**
     * @param SubscriptionInterface $subscription
     */
    public function assignTokenValue(SubscriptionInterface $subscription): void;
}
