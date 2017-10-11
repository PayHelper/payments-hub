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
}
