<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Helper;

final class DateTimeHelper implements DateTimeHelperInterface
{
    /**
     * @inheritdoc}
     */
    public function getCurrentMonth(int $next = 0): string
    {
        return date('m') + $next;
    }

    /**
     * @inheritdoc}
     */
    public function getCurrentDay(): string
    {
        return date('d');
    }

    /**
     * @inheritdoc}
     */
    public function getCurrentYear(): string
    {
        return date('Y');
    }
}
