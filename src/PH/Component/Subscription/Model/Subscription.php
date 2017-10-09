<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableTrait;

class Subscription implements SubscriptionInterface
{
    use TimestampableTrait;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var string|null
     */
    protected $number;

    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var string
     */
    protected $interval = SubscriptionInterface::INTERVAL_MONTH;

    /**
     * @var \DateTimeInterface|null
     */
    protected $startDate;

    /**
     * @var string|null
     */
    protected $type = SubscriptionInterface::TYPE_RECURRING;

    /**
     * @var Collection|SubscriptionItemInterface[]
     */
    protected $items;

    /**
     * @var \DateTimeInterface|null
     */
    protected $checkoutCompletedAt;

    /**
     * @var int
     */
    protected $itemsTotal = 0;

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @var string
     */
    protected $state = SubscriptionInterface::STATE_NEW;

    /**
     * Subscription constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->startDate = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrencyCode(string $currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getInterval(): string
    {
        return $this->interval;
    }

    /**
     * {@inheritdoc}
     */
    public function setInterval(string $interval)
    {
        $this->interval = $interval;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(?\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getCheckoutCompletedAt(): ?\DateTimeInterface
    {
        return $this->checkoutCompletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCheckoutCompletedAt(?\DateTimeInterface $checkoutCompletedAt): void
    {
        $this->checkoutCompletedAt = $checkoutCompletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function isCheckoutCompleted(): bool
    {
        return null !== $this->checkoutCompletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function completeCheckout(): void
    {
        $this->checkoutCompletedAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * {@inheritdoc}
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function clearItems(): void
    {
        $this->items->clear();

        $this->recalculateItemsTotal();
    }

    /**
     * {@inheritdoc}
     */
    public function countItems(): int
    {
        return $this->items->count();
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(SubscriptionItemInterface $item): void
    {
        if ($this->hasItem($item)) {
            return;
        }

        $this->itemsTotal += $item->getTotal();
        $this->items->add($item);
        $item->setSubscription($this);
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(SubscriptionItemInterface $item): void
    {
        if ($this->hasItem($item)) {
            $this->items->removeElement($item);
            $this->itemsTotal -= $item->getTotal();
            $item->setSubscription(null);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem(SubscriptionItemInterface $item): bool
    {
        return $this->items->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsTotal(): int
    {
        return $this->itemsTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function recalculateItemsTotal(): void
    {
        $this->itemsTotal = 0;
        foreach ($this->items as $item) {
            $this->itemsTotal += $item->getTotal();
        }

        $this->recalculateTotal();
    }

    /**
     * {@inheritdoc}
     */
    protected function recalculateTotal(): void
    {
        $this->total = $this->itemsTotal;

        if ($this->total < 0) {
            $this->total = 0;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalQuantity(): int
    {
        $quantity = 0;

        foreach ($this->items as $item) {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }
}
