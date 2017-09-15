<?php

declare(strict_types=1);

namespace PH\Component\Core\Factory;

use PH\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class PaymentMethodFactory implements PaymentMethodFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $decoratedFactory;

    /**
     * @var FactoryInterface
     */
    private $gatewayConfigFactory;

    /**
     * @param FactoryInterface $decoratedFactory
     * @param FactoryInterface $gatewayConfigFactory
     */
    public function __construct(FactoryInterface $decoratedFactory, FactoryInterface $gatewayConfigFactory)
    {
        $this->decoratedFactory = $decoratedFactory;
        $this->gatewayConfigFactory = $gatewayConfigFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(): PaymentMethodInterface
    {
        return $this->decoratedFactory->createNew();
    }

    /**
     * {@inheritdoc}
     */
    public function createWithGateway(string $gatewayFactory): PaymentMethodInterface
    {
        $gatewayConfig = $this->gatewayConfigFactory->createNew();
        $gatewayConfig->setFactoryName($gatewayFactory);

        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $this->decoratedFactory->createNew();
        $paymentMethod->setGatewayConfig($gatewayConfig);

        return $paymentMethod;
    }
}
