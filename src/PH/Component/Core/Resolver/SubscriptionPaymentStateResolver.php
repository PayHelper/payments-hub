<?php

declare(strict_types=1);

namespace PH\Component\Core\Resolver;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;
use SM\Factory\FactoryInterface;
use SM\StateMachine\StateMachineInterface;
use PH\Component\Core\SubscriptionPaymentTransitions;

final class SubscriptionPaymentStateResolver implements StateResolverInterface
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
     */
    public function resolve(SubscriptionInterface $subscription)
    {
        $stateMachine = $this->stateMachineFactory->get($subscription, SubscriptionPaymentTransitions::GRAPH);
        $targetTransition = $this->getTargetTransition($subscription);

        if (null !== $targetTransition) {
            $this->applyTransition($stateMachine, $targetTransition);
        }
    }

    /**
     * @param StateMachineInterface $stateMachine
     * @param string                $transition
     */
    private function applyTransition(StateMachineInterface $stateMachine, $transition)
    {
        if ($stateMachine->can($transition)) {
            $stateMachine->apply($transition);
        }
    }

    /**
     * @param SubscriptionInterface $subscription
     *
     * @return string|null
     */
    private function getTargetTransition(SubscriptionInterface $subscription)
    {
        $refundedPaymentTotal = 0;
        $refundedPayments = $this->getPaymentsWithState($subscription, PaymentInterface::STATE_REFUNDED);

        foreach ($refundedPayments as $payment) {
            $refundedPaymentTotal += $payment->getAmount();
        }

        if (0 < $refundedPayments->count() && $refundedPaymentTotal >= $subscription->getTotal()) {
            return SubscriptionPaymentTransitions::TRANSITION_REFUND;
        }

        if ($refundedPaymentTotal < $subscription->getTotal() && 0 < $refundedPaymentTotal) {
            return SubscriptionPaymentTransitions::TRANSITION_PARTIALLY_REFUND;
        }

        $completedPaymentTotal = 0;
        $completedPayments = $this->getPaymentsWithState($subscription, PaymentInterface::STATE_COMPLETED);

        foreach ($completedPayments as $payment) {
            $completedPaymentTotal += $payment->getAmount();
        }

        if (0 < $completedPayments->count() && $completedPaymentTotal >= $subscription->getTotal()) {
            return SubscriptionPaymentTransitions::TRANSITION_PAY;
        }

        if ($completedPaymentTotal < $subscription->getTotal() && 0 < $completedPaymentTotal) {
            return SubscriptionPaymentTransitions::TRANSITION_PARTIALLY_PAY;
        }

        $cancelledPayments = $this->getPaymentsWithState($subscription, PaymentInterface::STATE_CANCELLED);

        if (0 < $cancelledPayments->count()) {
            return SubscriptionPaymentTransitions::TRANSITION_CANCEL;
        }

        return null;
    }

    /**
     * @param SubscriptionInterface $subscription
     * @param string                $state
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    private function getPaymentsWithState(SubscriptionInterface $subscription, string $state)
    {
        return $subscription->getPayments()->filter(function (PaymentInterface $payment) use ($state) {
            return $state === $payment->getState();
        });
    }
}
