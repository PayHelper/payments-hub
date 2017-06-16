<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Model;

use Sylius\Component\Order\Model\Order as BaseOrder;

class Order extends BaseOrder implements OrderInterface
{
    /**
     * @var string
     */
    protected $providerType;

    /**
     * @return string
     */
    public function getProviderType()
    {
        return $this->providerType;
    }

    /**
     * @param string $providerType
     */
    public function setProviderType($providerType)
    {
        $this->providerType = $providerType;
    }
}
