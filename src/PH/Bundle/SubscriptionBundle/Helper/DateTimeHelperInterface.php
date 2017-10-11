<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Helper;

interface DateTimeHelperInterface
{
    /**
     * @param int $next
     *
     * @return string
     */
    public function getCurrentMonth(int $next = 0): string;

    /**
     * @return string
     */
    public function getCurrentDay(): string;

    /**
     * @return string
     */
    public function getCurrentYear(): string;
}
