<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use PH\Component\Subscription\Model\SubscriptionAwareInterface;
use Sylius\Component\Payment\Model\PaymentInterface as BasePaymentInterface;

interface PaymentInterface extends BasePaymentInterface, SubscriptionAwareInterface
{
    /**
     * @return \DateTimeInterface|null
     */
    public function getCanceledAt(): ?\DateTimeInterface;

    /**
     * @param \DateTimeInterface|null $dateTime
     */
    public function setCanceledAt(?\DateTimeInterface $dateTime): void;
}
