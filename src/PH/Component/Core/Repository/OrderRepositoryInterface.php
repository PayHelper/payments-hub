<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use PH\Component\Core\Model\OrderInterface;

interface OrderRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return null|OrderInterface
     */
    public function findByOrderId(int $id): ?OrderInterface;
}
