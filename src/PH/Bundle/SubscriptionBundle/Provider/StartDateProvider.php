<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Provider;

use PH\Bundle\SubscriptionBundle\Helper\DateTimeHelperInterface;

final class StartDateProvider implements StartDateProviderInterface
{
    private $dateTimeHelper;

    public function __construct(DateTimeHelperInterface $dateTimeHelper)
    {
        $this->dateTimeHelper = $dateTimeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDates(): array
    {
        $now = $this->dateTimeHelper->getCurrentDateTime();
        $dates = [];

        if ($now < $this->dateTimeHelper->getDate(1)) {
            $dates[$this->dateTimeHelper->getFormattedDate(1)] = $this->dateTimeHelper->getFormattedDate(1);
        }

        if ($now < $this->dateTimeHelper->getDate(15)) {
            $dates[$this->dateTimeHelper->getFormattedDate(15)] = $this->dateTimeHelper->getFormattedDate(15);
        }

        return array_merge($dates, [
            $this->dateTimeHelper->getFormattedDate(1, 1) => $this->dateTimeHelper->getFormattedDate(1, 1),
            $this->dateTimeHelper->getFormattedDate(15, 1) => $this->dateTimeHelper->getFormattedDate(15, 1),
        ]);
    }
}
