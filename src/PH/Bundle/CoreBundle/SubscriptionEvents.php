<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle;

final class SubscriptionEvents
{
    /**
     * The CREATE event occurs when subscription is created.
     *
     * This event allows you to modify subscription when it was created.
     *
     * @Event("PH\Bundle\CoreBundle\Event\SubscriptionEvent")
     *
     * @var string
     */
    const CREATE = 'create';

    /**
     * The UPDATE event occurs when subscription is updated.
     *
     * This event allows you to modify subscription when it was created.
     *
     * @Event("PH\Bundle\CoreBundle\Event\SubscriptionEvent")
     *
     * @var string
     */
    const UPDATE = 'update';
}
