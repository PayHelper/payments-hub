<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Payum\Core\Model\GatewayConfigInterface;
use Sylius\Component\Payment\Model\PaymentMethodInterface as BasePaymentInterface;

interface PaymentMethodInterface extends BasePaymentInterface
{
    /**
     * @param GatewayConfigInterface $gateway
     */
    public function setGatewayConfig(GatewayConfigInterface $gateway);

    /**
     * @return GatewayConfigInterface
     */
    public function getGatewayConfig();
}
