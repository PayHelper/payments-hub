<?php

declare(strict_types=1);

namespace PH\Component\Core\Processor;

use PH\Component\Core\Model\SubscriptionInterface;

interface SubscriptionProcessorInterface
{
    /**
     * @param SubscriptionInterface $subscription
     */
    public function process(SubscriptionInterface $subscription): void;
}
