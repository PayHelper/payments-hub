<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use PH\Component\Core\Factory\PaymentMethodFactoryInterface;
use PH\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Payment\Repository\PaymentMethodRepositoryInterface;

final class PaymentContext implements Context
{
    /**
     * @var PaymentMethodRepositoryInterface
     */
    private $paymentMethodRepository;

    /**
     * @var PaymentMethodFactoryInterface
     */
    private $paymentMethodFactory;

    /**
     * @var array
     */
    private $gatewayFactories;

    /**
     * PaymentContext constructor.
     *
     * @param PaymentMethodRepositoryInterface $paymentMethodRepository
     * @param PaymentMethodFactoryInterface    $paymentMethodFactory
     * @param array                            $gatewayFactories
     */
    public function __construct(
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        PaymentMethodFactoryInterface $paymentMethodFactory,
        array $gatewayFactories
    ) {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentMethodFactory = $paymentMethodFactory;
        $this->gatewayFactories = $gatewayFactories;
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode
     */
    public function theSystemHasAPaymentMethodWithACode($paymentMethodName, $paymentMethodCode)
    {
        $this->createPaymentMethod($paymentMethodName, $paymentMethodCode, 'Offline', '', 0);
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode and Paypal Express Checkout gateway
     */
    public function theSystemHasPaymentMethodWithCodeAndPaypalExpressCheckoutGateway(
        string $paymentMethodName,
        string $paymentMethodCode
    ) {
        $this->createPaymentMethod($paymentMethodName, $paymentMethodCode, 'Paypal Express Checkout', 'paypal desc', 1, [
            'username' => 'TEST',
            'password' => 'TEST',
            'signature' => 'TEST',
            'payum.http_client' => '@sylius.payum.http_client',
            'sandbox' => true,
        ]);
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode and a :method and Mollie gateway
     */
    public function theSystemHasPaymentMethodWithCodeAndAAndMollieGateway(
        string $paymentMethodName,
        string $paymentMethodCode,
        string $method
    ) {
        $this->createPaymentMethod(
            $paymentMethodName,
            $paymentMethodCode,
            'Mollie',
            'Mollie instructions',
            1,
            [
                'apiKey' => 'TEST',
                'method' => $method,
            ],
            true
        );
    }

    /**
     * @param string   $name
     * @param string   $code
     * @param string   $gatewayFactory
     * @param string   $description
     * @param int|null $position
     * @param array    $config
     * @param bool     $supportsRecurring
     *
     * @return PaymentMethodInterface
     */
    private function createPaymentMethod(
        string $name,
        string $code,
        string $gatewayFactory = 'Offline',
        string $description = '',
        int $position = null,
        array $config = [],
        bool $supportsRecurring = false
    ): PaymentMethodInterface {
        $gatewayFactory = array_search($gatewayFactory, $this->gatewayFactories);

        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $this->paymentMethodFactory->createWithGateway($gatewayFactory);
        $paymentMethod->setName(ucfirst($name));
        $paymentMethod->setCode($code);
        $paymentMethod->setDescription($description);
        $paymentMethod->setEnabled(true);
        $paymentMethod->getGatewayConfig()->setGatewayName($gatewayFactory);
        $paymentMethod->getGatewayConfig()->setConfig($config);

        if ($supportsRecurring) {
            $paymentMethod->setSupportsRecurring(true);
        }

        if (null !== $position) {
            $paymentMethod->setPosition($position);
        }

        $this->paymentMethodRepository->add($paymentMethod);

        return $paymentMethod;
    }
}
