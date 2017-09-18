<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use PH\Component\Core\Model\OrderInterface;

interface OrderRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return null|OrderInterface
     */
    public function findByOrderId(string $id): ?OrderInterface;

    /**
     * @param string $token
     *
     * @return null|OrderInterface
     */
    public function getOneByToken(string $token): ?OrderInterface;
}
