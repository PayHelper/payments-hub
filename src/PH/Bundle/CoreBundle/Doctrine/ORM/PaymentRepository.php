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
    public function findOneBySubscriptionId(string $paymentId, string $subscriptionId): ?PaymentInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :paymentId')
            ->andWhere('o.order = :id')
            ->setParameter('paymentId', $paymentId)
            ->setParameter('id', $subscriptionId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
