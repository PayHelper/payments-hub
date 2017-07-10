<?php

declare(strict_types=1);

namespace PH\Component\Core\OrderProcessing;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Payment\Provider\OrderPaymentProviderInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Webmozart\Assert\Assert;

final class OrderPaymentProcessor implements OrderProcessorInterface
{
    /**
     * @var OrderPaymentProviderInterface
     */
    private $orderPaymentProvider;

    /**
     * @var string
     */
    private $targetState;

    /**
     * @param OrderPaymentProviderInterface $orderPaymentProvider
     * @param string                        $targetState
     */
    public function __construct(
        OrderPaymentProviderInterface $orderPaymentProvider,
        string $targetState = PaymentInterface::STATE_CART
    ) {
        $this->orderPaymentProvider = $orderPaymentProvider;
        $this->targetState = $targetState;
    }

    /**
     * {@inheritdoc}
     */
    public function process(BaseOrderInterface $order)
    {
        /* @var OrderInterface $order */
        Assert::isInstanceOf($order, OrderInterface::class);

        if (OrderInterface::STATE_CANCELLED === $order->getState()) {
            return;
        }

        if (0 === $order->getTotal()) {
            return;
        }

        $lastPayment = $order->getLastPayment($this->targetState);

        if (null !== $lastPayment) {
            $lastPayment->setCurrencyCode($order->getCurrencyCode());
            $lastPayment->setAmount($order->getTotal());

            return;
        }

        try {
            $newPayment = $this->orderPaymentProvider->provideOrderPayment($order, $this->targetState);
            $order->addPayment($newPayment);
        } catch (\InvalidArgumentException $exception) {
            return;
        }
    }
}
