<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PH\Component\Core\SubscriptionPurchaseStates;
use PH\Component\Core\SubscriptionPaymentStates;
use PH\Component\Subscription\Model\Subscription as BaseSubscription;

class Subscription extends BaseSubscription implements SubscriptionInterface
{
    /**
     * @var Collection|PaymentInterface[]
     */
    protected $payments;

    /**
     * @var string
     */
    protected $purchaseState = SubscriptionPurchaseStates::STATE_CART;

    /**
     * @var string
     */
    protected $paymentState = SubscriptionPaymentStates::STATE_CART;

    /**
     * @var null|string
     */
    protected $tokenValue;

    /**
     * Subscription constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->payments = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * {@inheritdoc}
     */
    public function setPayments(Collection $payments): void
    {
        $this->payments = $payments;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPayments(): bool
    {
        return !$this->payments->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function addPayment(PaymentInterface $payment): void
    {
        /** @var PaymentInterface $payment */
        if (!$this->hasPayment($payment)) {
            $this->payments->add($payment);
            $payment->setSubscription($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removePayment(PaymentInterface $payment): void
    {
        /** @var PaymentInterface $payment */
        if ($this->hasPayment($payment)) {
            $this->payments->removeElement($payment);
            $payment->setSubscription(null);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasPayment(PaymentInterface $payment): bool
    {
        return $this->payments->contains($payment);
    }

    /**
     * @param string|null $state
     *
     * @return PaymentInterface|null
     */
    public function getLastPayment(string $state = null): ?PaymentInterface
    {
        if ($this->payments->isEmpty()) {
            return null;
        }

        $payment = $this->payments->filter(function (PaymentInterface $payment) use ($state) {
            return null === $state || $payment->getState() === $state;
        })->last();

        return false !== $payment ? $payment : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPurchaseState(): string
    {
        return $this->purchaseState;
    }

    /**
     * {@inheritdoc}
     */
    public function setPurchaseState(string $purchaseState): void
    {
        $this->purchaseState = $purchaseState;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentState(): string
    {
        return $this->paymentState;
    }

    /**
     * {@inheritdoc}
     */
    public function setPaymentState(string $paymentState): void
    {
        $this->paymentState = $paymentState;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenValue(): ?string
    {
        return $this->tokenValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenValue(string $tokenValue): void
    {
        $this->tokenValue = $tokenValue;
    }
}
