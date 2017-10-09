<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use PH\Component\Core\Model\SubscriptionInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface SubscriptionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return null|SubscriptionInterface
     */
    public function findByOrderId(string $id): ?SubscriptionInterface;

    /**
     * @param string $token
     *
     * @return null|SubscriptionInterface
     */
    public function getOneByToken(string $token): ?SubscriptionInterface;
}
