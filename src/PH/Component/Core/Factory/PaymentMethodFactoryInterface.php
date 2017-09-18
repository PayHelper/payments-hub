<?php

declare(strict_types=1);

namespace PH\Component\Core\Factory;

use PH\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface PaymentMethodFactoryInterface extends FactoryInterface
{
    /**
     * @param string $gatewayFactory
     *
     * @return PaymentMethodInterface
     */
    public function createWithGateway(string $gatewayFactory): PaymentMethodInterface;
}
