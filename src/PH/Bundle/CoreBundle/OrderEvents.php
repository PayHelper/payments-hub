<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle;

final class OrderEvents
{
    /**
     * The ORDER_CREATE event occurs when order is created.
     *
     * This event allows you to modify order when it was created.
     *
     * @Event("PH\Bundle\CoreBundle\Event\OrderEvent")
     *
     * @var string
     */
    const CREATE = 'create';

    /**
     * The ORDER_UPDATE event occurs when order is updated.
     *
     * This event allows you to modify order when it was created.
     *
     * @Event("PH\Bundle\CoreBundle\Event\OrderEvent")
     *
     * @var string
     */
    const UPDATE = 'update';
}
