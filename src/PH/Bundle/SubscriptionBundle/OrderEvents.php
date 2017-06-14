<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle;

class OrderEvents
{
    /**
     * The ORDER_CREATE event occurs when order is created.
     *
     * This event allows you to modify order when it was created.
     *
     * @Event("PH\Bundle\SubscriptionBundle\Event\OrderEvent")
     *
     * @var string
     */
    public const ORDER_CREATE = 'swp.order.create';

    /**
     * The ORDER_UPDATE event occurs when order is updated.
     *
     * This event allows you to modify order when it was created.
     *
     * @Event("PH\Bundle\SubscriptionBundle\Event\OrderEvent")
     *
     * @var string
     */
    public const ORDER_UPDATE = 'swp.order.update';
}
