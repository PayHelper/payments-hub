<?php

declare(strict_types=1);

namespace PH\Component\Core\Payment\Provider;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;

interface SubscriptionPaymentProviderInterface
{
    /**
     * @param SubscriptionInterface $subscription
     * @param string                $targetState
     *
     * @return PaymentInterface
     */
    public function provideSubscriptionPayment(SubscriptionInterface $subscription, string $targetState): PaymentInterface;
}
