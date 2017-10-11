<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Sender;

use PH\Component\Core\Model\SubscriptionInterface;

interface SubscriptionPayloadSenderInterface
{
    /**
     * @param SubscriptionInterface $subscription
     */
    public function send(SubscriptionInterface $subscription): void;
}
