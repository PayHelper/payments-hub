<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use Doctrine\ORM\QueryBuilder;
use PH\Component\Core\Model\SubscriptionInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface SubscriptionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return null|SubscriptionInterface
     */
    public function findOneBySubscriptionId(string $id): ?SubscriptionInterface;

    /**
     * @param string $token
     *
     * @return null|SubscriptionInterface
     */
    public function getOneByToken(string $token): ?SubscriptionInterface;

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $criteria
     */
    public function applyCustomCriteria(QueryBuilder $queryBuilder, array $criteria = []): void;
}
