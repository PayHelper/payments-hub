<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Model;

use Sylius\Component\Order\Model\Order as BaseOrder;

class Order extends BaseOrder implements OrderInterface
{
}
