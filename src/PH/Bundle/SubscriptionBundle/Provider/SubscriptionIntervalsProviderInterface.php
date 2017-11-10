<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Provider;

interface SubscriptionIntervalsProviderInterface
{
    public function getIntervals(): array;
}
