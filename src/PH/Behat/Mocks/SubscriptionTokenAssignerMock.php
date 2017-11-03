<?php

declare(strict_types=1);

namespace PH\Behat\Mocks;

use PH\Component\Core\Assigner\SubscriptionTokenAssignerInterface;
use PH\Component\Core\Model\SubscriptionInterface;

final class SubscriptionTokenAssignerMock implements SubscriptionTokenAssignerInterface
{
    /**
     * @param SubscriptionInterface $subscription
     */
    public function assignTokenValue(SubscriptionInterface $subscription): void
    {
        $subscription->setTokenValue('12345abcde');
    }
}
