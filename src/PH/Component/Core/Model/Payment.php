<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use PH\Component\Subscription\Model\SubscriptionInterface as BaseSubscriptionInterface;
use Sylius\Component\Payment\Model\Payment as BasePayment;

class Payment extends BasePayment implements PaymentInterface
{
    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * @var \DateTimeInterfac
     */
    protected $canceledAt;

    /**
     * {@inheritdoc}
     */
    public function getCanceledAt(): ?\DateTimeInterface
    {
        return $this->canceledAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanceledAt(?\DateTimeInterface $dateTime): void
    {
        $this->canceledAt = $dateTime;
    }

    /**
     * {@inheritdoc}
     */
    public function cancel()
    {
        $this->canceledAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscription(): ?BaseSubscriptionInterface
    {
        return $this->subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubscription(?BaseSubscriptionInterface $subscription): void
    {
        $this->subscription = $subscription;
    }
}
