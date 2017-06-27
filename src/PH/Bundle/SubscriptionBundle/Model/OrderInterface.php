<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Model;

use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;

/**
 * Interface OrderInterface
 */
interface OrderInterface extends BaseOrderInterface
{
//    /**
//     * @return string
//     */
//    public function getProviderType();
//
//    /**
//     * @param string $providerType
//     */
//    public function setProviderType($providerType);


    /**
     * @return string
     */
    public function getCurrencyCode(): string;

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode): void;
}
