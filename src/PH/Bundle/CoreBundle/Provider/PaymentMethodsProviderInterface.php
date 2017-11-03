<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Provider;

interface PaymentMethodsProviderInterface
{
    /**
     * @param string $type
     *
     * @return array
     */
    public function getSupportedMethods(string $type): array;
}
