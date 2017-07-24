<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use PH\Component\Core\Model\PaymentInterface;

interface PaymentRepositoryInterface
{
    /**
     * @param int $paymentId
     * @param int $orderId
     *
     * @return null|PaymentInterface
     */
    public function findOneByOrderId(int $paymentId, int $orderId): ?PaymentInterface;
}
