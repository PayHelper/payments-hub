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
