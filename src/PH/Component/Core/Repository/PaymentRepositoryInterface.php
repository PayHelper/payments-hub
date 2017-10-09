<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use PH\Component\Core\Model\PaymentInterface;

interface PaymentRepositoryInterface
{
    /**
     * @param string $paymentId
     * @param string $subscriptionId
     *
     * @return null|PaymentInterface
     */
    public function findOneBySubscriptionId(string $paymentId, string $subscriptionId): ?PaymentInterface;
}
