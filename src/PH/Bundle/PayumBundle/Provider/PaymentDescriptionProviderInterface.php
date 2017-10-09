<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Provider;

use PH\Component\Core\Model\PaymentInterface;

interface PaymentDescriptionProviderInterface
{
    /**
     * @param PaymentInterface $payment
     *
     * @return string
     */
    public function getPaymentDescription(PaymentInterface $payment): string;
}
