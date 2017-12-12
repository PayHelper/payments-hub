<?php

declare(strict_types=1);

namespace PH\Component\Core;

final class SubscriptionTransitions
{
    const GRAPH = 'ph_subscription';

    const TRANSITION_CREATE = 'create';

    const TRANSITION_CANCEL = 'cancel';

    const TRANSITION_FULFILL = 'fulfill';

    private function __construct()
    {
    }
}
