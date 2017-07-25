<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Doctrine\ORM;

use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Repository\PaymentRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository implements PaymentRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneByOrderId(int $paymentId, int $orderId): ?PaymentInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :paymentId')
            ->andWhere('o.order = :orderId')
            ->setParameter('paymentId', $paymentId)
            ->setParameter('orderId', $orderId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
