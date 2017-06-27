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
    const ORDER_CREATE = 'ph.order.create';

    /**
     * The ORDER_UPDATE event occurs when order is updated.
     *
     * This event allows you to modify order when it was created.
     *
     * @Event("PH\Bundle\SubscriptionBundle\Event\OrderEvent")
     *
     * @var string
     */
    const ORDER_UPDATE = 'ph.order.update';
}
