<?php

declare(strict_types=1);

namespace PH\Component\Core\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PaymentMethodRepositoryInterface extends RepositoryInterface
{
    /**
     * @param bool $supportsRecurring
     *
     * @return array
     */
    public function findBySupportsRecurring(bool $supportsRecurring): array;
}
