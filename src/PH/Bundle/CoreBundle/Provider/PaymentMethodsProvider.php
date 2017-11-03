<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Provider;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Repository\PaymentMethodRepositoryInterface;

final class PaymentMethodsProvider implements PaymentMethodsProviderInterface
{
    /**
     * @var PaymentMethodRepositoryInterface
     */
    private $paymentMethodRepository;

    /**
     * PaymentMethodsProvider constructor.
     *
     * @param PaymentMethodRepositoryInterface $paymentMethodRepository
     */
    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedMethods(string $type): array
    {
        $supportsRecurring = false;

        if (SubscriptionInterface::TYPE_RECURRING === $type) {
            $supportsRecurring = true;
        }

        return $this->paymentMethodRepository->findBySupportsRecurring($supportsRecurring);
    }
}
