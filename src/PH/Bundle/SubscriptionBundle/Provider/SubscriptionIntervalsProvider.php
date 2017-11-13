<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Provider;

final class SubscriptionIntervalsProvider implements SubscriptionIntervalsProviderInterface
{
    private $intervals = [];

    public function __construct(array $intervals)
    {
        $this->intervals = $intervals;
    }

    public function getIntervals(): array
    {
        return $this->intervals;
    }
}
