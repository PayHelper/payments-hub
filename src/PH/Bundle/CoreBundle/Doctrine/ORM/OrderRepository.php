<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Doctrine\ORM;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Bundle\OrderBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

class OrderRepository extends BaseOrderRepository implements OrderRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByOrderId(int $id): ?OrderInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :orderId')
            ->leftJoin('o.items', 'i')
            ->addSelect('i')
            ->setParameter('orderId', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
