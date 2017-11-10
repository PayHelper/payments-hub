<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Helper;

final class DateTimeHelper implements DateTimeHelperInterface
{
    /**
     * @inheritdoc}
     */
    public function getDate(int $day, int $months = 0): \DateTimeInterface
    {
        $date = new \DateTime(date('Y-m-'.$day));

        if (0 !== $months) {
            $date->modify(sprintf('+%d months', $months));
        }

        return $date;
    }

    /**
     * @inheritdoc}
     */
    public function getFormattedDate(int $day, int $months = 0, $format = 'Y-m-d'): string
    {
        return $this->getDate($day, $months)->format($format);
    }

    /**
     * @inheritdoc}
     */
    public function getCurrentDate(): \DateTimeInterface
    {
        return new \DateTime();
    }
}
