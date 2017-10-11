<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Facade;

use PH\Component\Core\Model\SubscriptionInterface;

interface SubscriptionFacadeInterface
{
    /**
     * @param SubscriptionInterface $subscription
     *
     * @return SubscriptionInterface
     */
    public function prepareSubscription(SubscriptionInterface $subscription): SubscriptionInterface;
}
