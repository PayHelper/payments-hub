<?php

declare(strict_types=1);

namespace PH\Component\Core\Assigner;

use PH\Component\Core\Model\SubscriptionInterface;
use Sylius\Component\Resource\Generator\RandomnessGeneratorInterface;

final class SubscriptionTokenAssigner implements SubscriptionTokenAssignerInterface
{
    /**
     * @var RandomnessGeneratorInterface
     */
    private $generator;

    /**
     * @param RandomnessGeneratorInterface $generator
     */
    public function __construct(RandomnessGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param SubscriptionInterface $subscription
     */
    public function assignTokenValue(SubscriptionInterface $subscription): void
    {
        $subscription->setTokenValue($this->generator->generateUriSafeString(10));
    }
}
