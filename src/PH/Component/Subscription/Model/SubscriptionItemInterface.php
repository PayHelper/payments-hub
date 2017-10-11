<?php

declare(strict_types=1);

namespace PH\Component\Subscription\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface SubscriptionItemInterface extends SubscriptionAwareInterface, ResourceInterface
{
    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void;

    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @return int
     */
    public function getUnitPrice(): int;

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice(int $unitPrice): void;

    /**
     * @return int
     */
    public function getTotal(): int;
}
