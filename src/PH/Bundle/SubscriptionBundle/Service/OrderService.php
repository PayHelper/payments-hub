<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Service;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderService implements OrderServiceInterface
{
    /**
     * @var FactoryInterface
     */
    protected $orderItemFactory;

    /**
     * @var OrderItemQuantityModifierInterface
     */
    protected $orderItemQuantityModifier;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var OrderModifierInterface
     */
    protected $orderModifier;

    /**
     * OrderService constructor.
     *
     * @param FactoryInterface                   $orderItemFactory
     * @param OrderItemQuantityModifierInterface $orderItemQuantityModifier
     */
    public function __construct(
        FactoryInterface $orderItemFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        EventDispatcherInterface $eventDispatcher,
        OrderModifierInterface $orderModifier
    ) {
        $this->orderItemFactory = $orderItemFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->eventDispatcher = $eventDispatcher;
        $this->orderModifier = $orderModifier;
    }

    public function prepareOrder(OrderInterface $order, SubscriptionInterface $subscription): OrderInterface
    {
        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemFactory->createNew();

        $this->orderItemQuantityModifier->modify($orderItem, 1);
        $orderItem->setUnitPrice($subscription->getAmount());
        $order->setCurrencyCode($subscription->getCurrencyCode());
        $this->orderModifier->addToOrder($order, $orderItem);

        $order->recalculateItemsTotal();
        $order->setSubscription($subscription);

        return $order;
    }
}
