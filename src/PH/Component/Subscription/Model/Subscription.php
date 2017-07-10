<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

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
     * @var string
     */
    protected $currencyCode;

    /**
     * @var string
     */
    protected $interval = SubscriptionInterface::INTERVAL_MONTH;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $code;

    /**
     * Subscription constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
