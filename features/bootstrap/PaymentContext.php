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
    public function theSystemHasAPaymentMethodWithACode(string $paymentMethodName, string $paymentMethodCode): void
    {
        $this->createPaymentMethod($paymentMethodName, $paymentMethodCode, 'Offline', '', 0);
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode and Mbe4 gateway
     */
    public function theSystemHasAPaymentMethodWithACodeAndMbe4Gateway(string $paymentMethodName, string $paymentMethodCode): void
    {
        $this->createPaymentMethod(
            $paymentMethodName,
            $paymentMethodCode,
            'Mbe4',
            'Mbe4 description',
            0,
            [
                'username' => 'user',
                'password' => 'pw',
                'clientId' => '12345',
                'serviceId' => '54321',
                'contentclass' => 1,
            ]
        );
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode and Paypal Express Checkout gateway
     */
    public function theSystemHasPaymentMethodWithCodeAndPaypalExpressCheckoutGateway(
        string $paymentMethodName,
        string $paymentMethodCode
    ): void {
        $this->createPaymentMethod($paymentMethodName, $paymentMethodCode, 'Paypal Express Checkout', 'paypal desc', 1, [
            'username' => 'TEST',
            'password' => 'TEST',
            'signature' => 'TEST',
            'payum.http_client' => '@sylius.payum.http_client',
            'sandbox' => true,
        ]);
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode and a :method method using Mollie gateway which supports recurring
     */
    public function theSystemHasPaymentMethodWithCodeAndAMethodUsingMollieGatewayWhichSupportsRecurring(
        string $paymentMethodName,
        string $paymentMethodCode,
        string $method
    ): void {
        $this->createMolliePaymentMethod($paymentMethodName, $paymentMethodCode, $method, true);
    }

    /**
     * @Given the system has a payment method :paymentMethodName with a code :paymentMethodCode and a :method method using Mollie gateway which does not support recurring
     */
    public function theSystemHasPaymentMethodWithCodeAndAMethodUsingMollieGatewayWhichDoesNotSupportRecurring(
        string $paymentMethodName,
        string $paymentMethodCode,
        string $method
    ): void {
        $this->createMolliePaymentMethod($paymentMethodName, $paymentMethodCode, $method, false);
    }

    private function createMolliePaymentMethod(string $paymentMethodName, string $paymentMethodCode, string $method, bool $supportsRecurring): void
    {
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
            $supportsRecurring
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
