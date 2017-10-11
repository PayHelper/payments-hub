<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Event;

use PH\Component\Core\Model\SubscriptionInterface;
use Symfony\Component\EventDispatcher\Event;

class SubscriptionEvent extends Event
{
    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * SubscriptionEvent constructor.
     *
     * @param SubscriptionInterface $subscription
     */
    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getSubscription(): SubscriptionInterface
    {
        return $this->subscription;
    }
}
