<?php

declare(strict_types=1);

namespace PH\Component\Core;

final class OrderTransitions
{
    const GRAPH = 'ph_order';

    const TRANSITION_CREATE = 'create';
    const TRANSITION_CANCEL = 'cancel';
    const TRANSITION_FULFILL = 'fulfill';

    private function __construct()
    {
    }
}
