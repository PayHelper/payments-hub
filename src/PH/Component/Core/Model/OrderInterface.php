<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;

interface OrderInterface extends BaseOrderInterface
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
    public function getCheckoutState(): string;

    /**
     * @param string $checkoutState
     */
    public function setCheckoutState(string $checkoutState): void;

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
     * @return string
     */
    public function getCurrencyCode(): ?string;

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode): void;
}
