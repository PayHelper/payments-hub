<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Doctrine\Common\Collections\Collection;
use PH\Component\Subscription\Model\SubscriptionInterface as BaseSubscriptionInterface;

interface SubscriptionInterface extends BaseSubscriptionInterface
{
    /**
     * @return Collection|PaymentInterface[]
     */
    public function getPayments(): Collection;

    /**
     * @param Collection|PaymentInterface[] $payments
     */
    public function setPayments(Collection $payments): void;

    /**
     * @return bool
     */
    public function hasPayments(): bool;

    /**
     * @param PaymentInterface $payment
     */
    public function addPayment(PaymentInterface $payment): void;

    /**
     * @param PaymentInterface $payment
     */
    public function removePayment(PaymentInterface $payment): void;

    /**
     * @param PaymentInterface $payment
     *
     * @return bool
     */
    public function hasPayment(PaymentInterface $payment): bool;

    /**
     * @param string|null $state
     *
     * @return null|PaymentInterface
     */
    public function getLastPayment(string $state = null): ?PaymentInterface;

    /**
     * @return string
     */
    public function getPurchaseState(): string;

    /**
     * @param string $purchaseState
     */
    public function setPurchaseState(string $purchaseState): void;

    /**
     * @return string
     */
    public function getPaymentState(): string;

    /**
     * @param string $paymentState
     */
    public function setPaymentState(string $paymentState): void;

    /**
     * @return null|string
     */
    public function getTokenValue(): ?string;

    /**
     * @param string $tokenValue
     */
    public function setTokenValue(string $tokenValue): void;

    /**
     * @return null|PaymentMethodInterface
     */
    public function getMethod(): ?PaymentMethodInterface;

    /**
     * @param null|PaymentMethodInterface $method
     */
    public function setMethod(?PaymentMethodInterface $method): void;

    /**
     * @return string
     */
    public function getIntention(): string;

    /**
     * @param string $intention
     */
    public function setIntention(string $intention): void;

    /**
     * @return string
     */
    public function getSource(): string;

    /**
     * @param string $source
     */
    public function setSource(string $source): void;
}
