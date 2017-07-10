<?php

declare(strict_types=1);

namespace PH\Component\Core\StateResolver;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;
use SM\Factory\FactoryInterface;
use SM\StateMachine\StateMachineInterface;
use PH\Component\Core\OrderPaymentTransitions;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 * @author Grzegorz Sadowski <grzegorz.sadowski@lakion.com>
 */
final class OrderPaymentStateResolver implements StateResolverInterface
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
    public function resolve(OrderInterface $order)
    {
        $stateMachine = $this->stateMachineFactory->get($order, OrderPaymentTransitions::GRAPH);
        $targetTransition = $this->getTargetTransition($order);

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
     * @param OrderInterface $order
     *
     * @return string|null
     */
    private function getTargetTransition(OrderInterface $order)
    {
        $refundedPaymentTotal = 0;
        $refundedPayments = $this->getPaymentsWithState($order, PaymentInterface::STATE_REFUNDED);

        foreach ($refundedPayments as $payment) {
            $refundedPaymentTotal += $payment->getAmount();
        }

        if (0 < $refundedPayments->count() && $refundedPaymentTotal >= $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_REFUND;
        }

        if ($refundedPaymentTotal < $order->getTotal() && 0 < $refundedPaymentTotal) {
            return OrderPaymentTransitions::TRANSITION_PARTIALLY_REFUND;
        }

        $completedPaymentTotal = 0;
        $completedPayments = $this->getPaymentsWithState($order, PaymentInterface::STATE_COMPLETED);

        foreach ($completedPayments as $payment) {
            $completedPaymentTotal += $payment->getAmount();
        }

        if (0 < $completedPayments->count() && $completedPaymentTotal >= $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_PAY;
        }

        if ($completedPaymentTotal < $order->getTotal() && 0 < $completedPaymentTotal) {
            return OrderPaymentTransitions::TRANSITION_PARTIALLY_PAY;
        }

        return null;
    }

    /**
     * @param OrderInterface $order
     * @param string         $state
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    private function getPaymentsWithState(OrderInterface $order, string $state)
    {
        return $order->getPayments()->filter(function (PaymentInterface $payment) use ($state) {
            return $state === $payment->getState();
        });
    }
}
