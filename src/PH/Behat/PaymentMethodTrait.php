<?php

declare(strict_types=1);

namespace PH\Behat;

use PH\Component\Core\Factory\PaymentMethodFactoryInterface;
use PH\Component\Core\Model\PaymentMethodInterface;
use PH\Component\Core\Repository\PaymentMethodRepositoryInterface;

trait PaymentMethodTrait
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
    public function createPaymentMethod(
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
