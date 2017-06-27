<?php

declare(strict_types=1);

namespace PH\Component\Core\Payment\Provider;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;

interface OrderPaymentProviderInterface
{
    /**
     * @param OrderInterface $order
     * @param string         $targetState
     *
     * @return PaymentInterface
     */
    public function provideOrderPayment(OrderInterface $order, string $targetState): PaymentInterface;
}
