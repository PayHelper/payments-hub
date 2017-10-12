<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use PH\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Bundle\PaymentBundle\Doctrine\ORM\PaymentMethodRepository as BaseRepository;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $criteria
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = []): void
    {
        $criteria = array_filter($criteria, function ($value) {
            return !is_null($value);
        });

        foreach ($criteria as $property => $value) {
            if (!in_array($property, array_merge($this->_class->getAssociationNames(), $this->_class->getFieldNames()), true)) {
                continue;
            }

            $name = $this->getPropertyName($property);

            if (is_array($value)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in($name, $value));
            } elseif ('1' === $value || '0' === $value) {
                $parameter = str_replace('.', '_', $property);
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq($name, ':'.$parameter))
                    ->setParameter($parameter, (int) $value)
                ;
            } elseif ('' !== $value) {
                $parameter = str_replace('.', '_', $property);
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq($name, ':'.$parameter))
                    ->setParameter($parameter, $value)
                ;
            }
        }
    }
}
