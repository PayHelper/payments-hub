<?php

declare(strict_types=1);

namespace PH\Component\Core\Processor;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Payment\Provider\SubscriptionPaymentProviderInterface;
use PH\Component\Core\SubscriptionPaymentStates;

final class SubscriptionPaymentProcessor implements SubscriptionProcessorInterface
{
    /**
     * @var SubscriptionPaymentProviderInterface
     */
    private $subscriptionPaymentProvider;

    /**
     * @var string
     */
    private $targetState;

    /**
     * @param SubscriptionPaymentProviderInterface $subscriptionPaymentProvider
     * @param string                               $targetState
     */
    public function __construct(
        SubscriptionPaymentProviderInterface $subscriptionPaymentProvider,
        string $targetState = PaymentInterface::STATE_NEW
    ) {
        $this->subscriptionPaymentProvider = $subscriptionPaymentProvider;
        $this->targetState = $targetState;
    }

    /**
     * {@inheritdoc}
     */
    public function process(SubscriptionInterface $subscription): void
    {
        if (SubscriptionInterface::STATE_CANCELLED === $subscription->getState()) {
            return;
        }

        if (0 === $subscription->getTotal()) {
            foreach ($subscription->getPayments(SubscriptionPaymentStates::STATE_NEW) as $payment) {
                $subscription->removePayment($payment);
            }

            return;
        }

        $lastPayment = $subscription->getLastPayment($this->targetState);

        if (null !== $lastPayment) {
            $lastPayment->setCurrencyCode($subscription->getCurrencyCode());
            $lastPayment->setAmount($subscription->getTotal());
            $lastPayment->setMethod($subscription->getMethod());

            return;
        }

        try {
            $newPayment = $this->subscriptionPaymentProvider
                ->provideSubscriptionPayment($subscription, $this->targetState);
            $subscription->addPayment($newPayment);
        } catch (\InvalidArgumentException $exception) {
            return;
        }
    }
}
