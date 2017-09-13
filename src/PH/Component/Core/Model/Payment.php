<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Payment\Model\Payment as BasePayment;

class Payment extends BasePayment implements PaymentInterface
{
    /**
     * @var BaseOrderInterface
     */
    protected $order;

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
    public function getOrder(): ?BaseOrderInterface
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(BaseOrderInterface $order = null): void
    {
        $this->order = $order;
    }
}
