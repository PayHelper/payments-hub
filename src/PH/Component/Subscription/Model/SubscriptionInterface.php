<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface SubscriptionInterface extends TimestampableInterface, ResourceInterface
{
    const INTERVAL_MONTH = '1 month';
    const INTERVAL_YEAR = '1 year';
    const INTERVAL_QUARTERLY = '3 months';

    const TYPE_RECURRING = 'recurring';
    const TYPE_NON_RECURRING = 'non-recurring';

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

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface;

    /**
     * @param \DateTimeInterface|null $startDate
     */
    public function setStartDate(?\DateTimeInterface $startDate): void;

    /**
     * @return null|string
     */
    public function getType(): ?string;

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void;
}
