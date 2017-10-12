<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Payum\Core\Model\GatewayConfigInterface;
use Sylius\Component\Payment\Model\PaymentMethod as BasePaymentMethod;
use Sylius\Component\Payment\Model\PaymentMethodTranslation;

class PaymentMethod extends BasePaymentMethod implements PaymentMethodInterface
{
    /**
     * @var GatewayConfigInterface
     */
    protected $gatewayConfig;

    /**
     * @var bool
     */
    protected $supportsRecurring = false;

    /**
     * PaymentMethod constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function setGatewayConfig(GatewayConfigInterface $gatewayConfig)
    {
        $this->gatewayConfig = $gatewayConfig;
    }

    /**
     * @return GatewayConfigInterface
     */
    public function getGatewayConfig()
    {
        return $this->gatewayConfig;
    }

    /**
     * {@inheritdoc}
     */
    public static function getTranslationClass()
    {
        return PaymentMethodTranslation::class;
    }

    /**
     * {@inheritdoc}
     */
    public function isSupportsRecurring(): bool
    {
        return $this->supportsRecurring;
    }

    /**
     * {@inheritdoc}
     */
    public function setSupportsRecurring(bool $supportsRecurring): void
    {
        $this->supportsRecurring = $supportsRecurring;
    }
}
