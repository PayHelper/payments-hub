<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Doctrine\ORM;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Repository\SubscriptionRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class SubscriptionRepository extends EntityRepository implements SubscriptionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneBySubscriptionId(string $id): ?SubscriptionInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :id')
            ->leftJoin('o.items', 'i')
            ->addSelect('i')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getOneByToken(string $token): ?SubscriptionInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.tokenValue = :token')
            ->leftJoin('o.items', 'i')
            ->addSelect('i')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function applyCustomCriteria($queryBuilder, $criteria): void
    {
        foreach ((array) $criteria as $key => $criterion) {
            if (false !== strpos($key, 'metadata.')) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq('metadata.key', ':key'))
                    ->setParameter('key', str_replace('metadata.', '', $key))
                    ->andWhere($queryBuilder->expr()->eq('metadata.value', ':value'))
                    ->setParameter('value', $criterion)
                ;

                unset($criteria[$key]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createPaginator(array $criteria = [], array $sorting = []): iterable
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->leftJoin('o.metadata', 'metadata')
        ;

        $this->applyCustomCriteria($queryBuilder, $criteria);
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $sorting);

        return $this->getPaginator($queryBuilder);
    }
}
