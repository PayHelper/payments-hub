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
}
