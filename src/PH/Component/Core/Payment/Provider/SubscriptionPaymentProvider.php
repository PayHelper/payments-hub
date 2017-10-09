<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PH\Component\Core\Payment\Provider;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Model\PaymentMethodInterface;
use PH\Component\Core\PaymentTransitions;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use Sylius\Component\Payment\Exception\UnresolvedDefaultPaymentMethodException;
use Sylius\Component\Payment\Factory\PaymentFactoryInterface;
use Sylius\Component\Payment\Resolver\DefaultPaymentMethodResolverInterface;
use Sylius\Component\Resource\StateMachine\StateMachineInterface;

final class SubscriptionPaymentProvider implements SubscriptionPaymentProviderInterface
{
    /**
     * @var DefaultPaymentMethodResolverInterface
     */
    private $defaultPaymentMethodResolver;

    /**
     * @var PaymentFactoryInterface
     */
    private $paymentFactory;

    /**
     * @var StateMachineFactoryInterface
     */
    private $stateMachineFactory;

    /**
     * @param DefaultPaymentMethodResolverInterface $defaultPaymentMethodResolver
     * @param PaymentFactoryInterface               $paymentFactory
     * @param StateMachineFactoryInterface          $stateMachineFactory
     */
    public function __construct(
        DefaultPaymentMethodResolverInterface $defaultPaymentMethodResolver,
        PaymentFactoryInterface $paymentFactory,
        StateMachineFactoryInterface $stateMachineFactory
    ) {
        $this->defaultPaymentMethodResolver = $defaultPaymentMethodResolver;
        $this->paymentFactory = $paymentFactory;
        $this->stateMachineFactory = $stateMachineFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function provideSubscriptionPayment(SubscriptionInterface $subscription, string $targetState): PaymentInterface
    {
        /** @var PaymentInterface $payment */
        $payment = $this->paymentFactory->createWithAmountAndCurrencyCode($subscription->getTotal(), $subscription->getCurrencyCode());

        $paymentMethod = $this->getDefaultPaymentMethod($payment, $subscription);
        $lastPayment = $this->getLastPayment($subscription);

        if (null !== $lastPayment) {
            $paymentMethod = $lastPayment->getMethod();
        }

        if (null === $paymentMethod) {
            throw new \InvalidArgumentException('Subscription payment could not be provided!');
        }

        $payment->setMethod($paymentMethod);
        $this->applyRequiredTransition($payment, $targetState);

        return $payment;
    }

    /**
     * @param SubscriptionInterface $subscription
     *
     * @return PaymentInterface|null
     */
    private function getLastPayment(SubscriptionInterface $subscription): ?PaymentInterface
    {
        $lastCancelledPayment = $subscription->getLastPayment(PaymentInterface::STATE_CANCELLED);
        if (null !== $lastCancelledPayment) {
            return $lastCancelledPayment;
        }

        $lastFailedPayment = $subscription->getLastPayment(PaymentInterface::STATE_FAILED);
        if (null !== $lastFailedPayment) {
            return $lastFailedPayment;
        }

        return null;
    }

    /**
     * @param PaymentInterface      $payment
     * @param SubscriptionInterface $subscription
     *
     * @return PaymentMethodInterface|null
     */
    private function getDefaultPaymentMethod(PaymentInterface $payment, SubscriptionInterface $subscription): ?PaymentMethodInterface
    {
        try {
            $payment->setSubscription($subscription);
            /** @var PaymentMethodInterface $paymentMethod */
            $paymentMethod = $this->defaultPaymentMethodResolver->getDefaultPaymentMethod($payment);

            return $paymentMethod;
        } catch (UnresolvedDefaultPaymentMethodException $exception) {
            return null;
        }
    }

    /**
     * @param PaymentInterface $payment
     * @param string           $targetState
     */
    private function applyRequiredTransition(PaymentInterface $payment, string $targetState): void
    {
        if ($targetState === $payment->getState()) {
            return;
        }

        /** @var StateMachineInterface $stateMachine */
        $stateMachine = $this->stateMachineFactory->get($payment, PaymentTransitions::GRAPH);

        $targetTransition = $stateMachine->getTransitionToState($targetState);
        if (null !== $targetTransition) {
            $stateMachine->apply($targetTransition);
        }
    }
}
