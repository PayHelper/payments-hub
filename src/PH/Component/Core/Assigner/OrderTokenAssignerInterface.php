<?php

declare(strict_types=1);

namespace PH\Component\Core\Assigner;

use PH\Component\Core\Model\OrderInterface;

interface OrderTokenAssignerInterface
{
    /**
     * @param OrderInterface $order
     */
    public function assignTokenValue(OrderInterface $order): void;
}
