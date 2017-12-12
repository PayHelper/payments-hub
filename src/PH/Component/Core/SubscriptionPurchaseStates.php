<?php

declare(strict_types=1);

namespace PH\Component\Core;

final class SubscriptionPurchaseStates
{
    const STATE_NEW = 'new';

    const STATE_COMPLETED = 'completed';

    const STATE_PAYMENT_SELECTED = 'payment_selected';

    const STATE_PAYMENT_SKIPPED = 'payment_skipped';

    private function __construct()
    {
    }
}
