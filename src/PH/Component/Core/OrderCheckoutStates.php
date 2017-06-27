<?php

declare(strict_types=1);

namespace PH\Component\Core;

final class OrderCheckoutStates
{
    const STATE_CART = 'cart';
    const STATE_COMPLETED = 'completed';
    const STATE_PAYMENT_SELECTED = 'payment_selected';
    const STATE_PAYMENT_SKIPPED = 'payment_skipped';

    private function __construct()
    {
    }
}
