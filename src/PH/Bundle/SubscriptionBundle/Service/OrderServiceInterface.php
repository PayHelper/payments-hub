<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Service;

use PH\Bundle\SubscriptionBundle\Model\OrderInterface;

interface OrderServiceInterface
{
    /**
     * @param OrderInterface $order
     * @param array          $data
     *
     * @return OrderInterface
     */
    public function prepareOrder(OrderInterface $order, array $data): OrderInterface;

    /**
     * @param OrderInterface $order
     * @param array          $data
     *
     * @return OrderInterface
     */
    public function updateOrder(OrderInterface $order, array $data): OrderInterface;
}
