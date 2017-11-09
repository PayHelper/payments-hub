<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Provider;

interface StartDateProviderInterface
{
    /**
     * @return array
     */
    public function getStartDates(): array;
}
