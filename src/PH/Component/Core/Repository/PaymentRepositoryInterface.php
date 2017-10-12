<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use PH\Component\Core\Model\PaymentInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PaymentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $paymentId
     * @param string $subscriptionId
     *
     * @return null|PaymentInterface
     */
    public function findOneBySubscriptionId(string $paymentId, string $subscriptionId): ?PaymentInterface;
}
