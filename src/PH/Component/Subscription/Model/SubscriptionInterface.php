<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface SubscriptionInterface extends TimestampableInterface, ResourceInterface
{
    const INTERVAL_MONTH = '1 month';

    const INTERVAL_YEAR = '1 year';

    const INTERVAL_QUARTERLY = '3 months';

    const TYPE_RECURRING = 'recurring';

    const TYPE_NON_RECURRING = 'non-recurring';

    const STATE_NEW = 'new';

    const STATE_CANCELLED = 'cancelled';

    const STATE_FULFILLED = 'fulfilled';

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
     * @return string|null
     */
    public function getInterval(): ?string;

    /**
     * @param string|null $interval
     */
    public function setInterval(?string $interval);

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

    /**
     * @return \DateTimeInterface|null
     */
    public function getPurchaseCompletedAt(): ?\DateTimeInterface;

    /**
     * @param \DateTimeInterface|null $purchaseCompletedAt
     */
    public function setPurchaseCompletedAt(?\DateTimeInterface $purchaseCompletedAt): void;

    public function completePurchase(): void;

    /**
     * @return Collection|SubscriptionItemInterface[]
     */
    public function getItems(): Collection;

    public function clearItems(): void;

    /**
     * @return int
     */
    public function countItems(): int;

    /**
     * @param SubscriptionItemInterface $item
     */
    public function addItem(SubscriptionItemInterface $item): void;

    /**
     * @param SubscriptionItemInterface $item
     */
    public function removeItem(SubscriptionItemInterface $item): void;

    /**
     * @param SubscriptionItemInterface $item
     *
     * @return bool
     */
    public function hasItem(SubscriptionItemInterface $item): bool;

    /**
     * @return int
     */
    public function getItemsTotal(): int;

    public function recalculateItemsTotal(): void;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @return int
     */
    public function getTotalQuantity(): int;

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param string $state
     */
    public function setState(string $state): void;

    /**
     * @return bool
     */
    public function isEmpty(): bool;
}
