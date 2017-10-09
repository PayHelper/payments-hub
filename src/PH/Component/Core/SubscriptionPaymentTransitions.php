<?php

declare(strict_types=1);

namespace PH\Component\Core;

final class SubscriptionPaymentTransitions
{
    const GRAPH = 'ph_subscription_payment';

    const TRANSITION_REQUEST_PAYMENT = 'request_payment';
    const TRANSITION_PARTIALLY_PAY = 'partially_pay';
    const TRANSITION_CANCEL = 'cancel';
    const TRANSITION_PAY = 'pay';
    const TRANSITION_PARTIALLY_REFUND = 'partially_refund';
    const TRANSITION_REFUND = 'refund';

    private function __construct()
    {
    }
}
