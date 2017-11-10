<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Helper;

interface DateTimeHelperInterface
{
    /**
     * @param int $day
     * @param int $months
     *
     * @return \DateTimeInterface
     */
    public function getDate(int $day, int $months = 0): \DateTimeInterface;

    /**
     * @param int    $day
     * @param int    $months
     * @param string $format
     *
     * @return string
     */
    public function getFormattedDate(int $day, int $months = 0, $format = 'Y-m-d'): string;

    /**
     * @return \DateTimeInterface
     */
    public function getCurrentDateTime(): \DateTimeInterface;
}
