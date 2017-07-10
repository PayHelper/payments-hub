<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Facade;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Subscription\Model\SubscriptionInterface;

interface OrderFacadeInterface
{
    /**
     * @param OrderInterface        $order
     * @param SubscriptionInterface $subscription
     *
     * @return OrderInterface
     */
    public function prepareOrder(OrderInterface $order, SubscriptionInterface $subscription): OrderInterface;
}
