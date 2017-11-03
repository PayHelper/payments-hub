<?php

declare(strict_types=1);

namespace PH\Behat\Mocks;

use PH\Bundle\SubscriptionBundle\Helper\DateTimeHelperInterface;

final class DateTimeHelperMock implements DateTimeHelperInterface
{
    /**
     * @inheritdoc}
     */
    public function getCurrentMonth(int $next = 0): string
    {
        return (string) (10 + $next);
    }

    /**
     * @inheritdoc}
     */
    public function getCurrentDay(): string
    {
        return '10';
    }

    /**
     * @inheritdoc}
     */
    public function getCurrentYear(): string
    {
        return '2017';
    }
}
