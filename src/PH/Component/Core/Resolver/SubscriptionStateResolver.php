<?php

declare(strict_types=1);

namespace PH\Component\Core\Resolver;

use SM\Factory\FactoryInterface;
use PH\Component\Core\SubscriptionPaymentStates;
use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\SubscriptionTransitions;

final class SubscriptionStateResolver implements StateResolverInterface
{
    /**
     * @var FactoryInterface
     */
    private $stateMachineFactory;

    /**
     * @param FactoryInterface $stateMachineFactory
     */
    public function __construct(FactoryInterface $stateMachineFactory)
    {
        $this->stateMachineFactory = $stateMachineFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \SM\SMException
     */
    public function resolve(SubscriptionInterface $subscription)
    {
        $stateMachine = $this->stateMachineFactory->get($subscription, SubscriptionTransitions::GRAPH);

        if ($this->canSubscriptionBeFulfilled($subscription) && $stateMachine->can(SubscriptionTransitions::TRANSITION_FULFILL)) {
            $stateMachine->apply(SubscriptionTransitions::TRANSITION_FULFILL);
        }

        if ($this->canSubscriptionBeCancelled($subscription) && $stateMachine->can(SubscriptionTransitions::TRANSITION_CANCEL)) {
            $stateMachine->apply(SubscriptionTransitions::TRANSITION_CANCEL);
        }
    }

    /**
     * @param SubscriptionInterface $subscription
     *
     * @return bool
     */
    private function canSubscriptionBeFulfilled(SubscriptionInterface $subscription)
    {
        return SubscriptionPaymentStates::STATE_PAID === $subscription->getPaymentState();
    }

    /**
     * @param SubscriptionInterface $subscription
     *
     * @return bool
     */
    private function canSubscriptionBeCancelled(SubscriptionInterface $subscription)
    {
        return SubscriptionPaymentStates::STATE_CANCELLED === $subscription->getPaymentState();
    }
}
