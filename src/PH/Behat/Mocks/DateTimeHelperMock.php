<?php

declare(strict_types=1);

namespace PH\Behat\Mocks;

use PH\Bundle\SubscriptionBundle\Helper\DateTimeHelperInterface;

final class DateTimeHelperMock implements DateTimeHelperInterface
{
    /**
     * @inheritdoc}
     */
    public function getDate(int $day, int $months = 0): \DateTimeInterface
    {
        $date = new \DateTime(date('2017-10-'.$day));

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
    public function getCurrentDateTime(): \DateTimeInterface
    {
        return new \DateTime(date('2017-10-09'));
    }
}
