<?php

declare(strict_types=1);

namespace PH\Component\Core\StateResolver;

use SM\Factory\FactoryInterface;
use PH\Component\Core\OrderPaymentStates;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\OrderTransitions;

final class OrderStateResolver implements StateResolverInterface
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
        $stateMachine = $this->stateMachineFactory->get($order, OrderTransitions::GRAPH);

        if ($this->canOrderBeFulfilled($order) && $stateMachine->can(OrderTransitions::TRANSITION_FULFILL)) {
            $stateMachine->apply(OrderTransitions::TRANSITION_FULFILL);
        }
    }

    /**
     * @param OrderInterface $order
     *
     * @return bool
     */
    private function canOrderBeFulfilled(OrderInterface $order)
    {
        return OrderPaymentStates::STATE_PAID === $order->getPaymentState();
    }
}
