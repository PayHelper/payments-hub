<?php

declare(strict_types=1);

namespace PH\Component\Payment;

final class PaymentTransitions
{
    const GRAPH = 'ph_payment';

    const TRANSITION_CREATE = 'create';
    const TRANSITION_PROCESS = 'process';
    const TRANSITION_COMPLETE = 'complete';
    const TRANSITION_FAIL = 'fail';
    const TRANSITION_CANCEL = 'cancel';
    const TRANSITION_REFUND = 'refund';
    const TRANSITION_VOID = 'void';

    private function __construct()
    {
    }
}
