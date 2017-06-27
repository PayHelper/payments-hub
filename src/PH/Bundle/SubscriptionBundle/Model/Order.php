<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Model;

use Sylius\Component\Order\Model\Order as BaseOrder;
use Webmozart\Assert\Assert;

class Order extends BaseOrder implements OrderInterface
{
    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * {@inheritdoc}
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrencyCode(string $currencyCode): void
    {
        Assert::string($currencyCode);
        $this->currencyCode = $currencyCode;
    }
}
