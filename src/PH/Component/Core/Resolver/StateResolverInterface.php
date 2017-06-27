<?php

declare(strict_types=1);

namespace PH\Component\Core\StateResolver;

use PH\Component\Core\Model\OrderInterface;

interface StateResolverInterface
{
    /**
     * @param OrderInterface $order
     */
    public function resolve(OrderInterface $order);
}
