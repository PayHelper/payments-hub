<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface SubscriptionInterface extends TimestampableInterface, ResourceInterface
{
    const INTERVAL_DAY = 'day';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';
    const INTERVAL_DONATION = 'donation';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return int|null
     */
    public function getAmount(): ?int;

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void;

    /**
     * @return string
     */
    public function getCurrencyCode(): ?string;

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode);

    /**
     * @return string
     */
    public function getInterval(): string;

    /**
     * @param string $interval
     */
    public function setInterval(string $interval);

    /**
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @param string $code
     */
    public function setCode(string $code): void;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;
}
