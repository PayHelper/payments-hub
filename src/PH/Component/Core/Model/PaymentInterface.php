<?php
/**
 * Created by PhpStorm.
 * User: rafal
 * Date: 14.06.2017
 * Time: 12:05.
 */

namespace PH\Component\Core\Model;

use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface as BasePaymentInterface;

interface PaymentInterface extends BasePaymentInterface
{
    /**
     * @return null|BaseOrderInterface
     */
    public function getOrder(): ?BaseOrderInterface;

    /**
     * @param BaseOrderInterface|null $order
     */
    public function setOrder(BaseOrderInterface $order = null): void;
}
