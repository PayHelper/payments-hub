<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Service;

use PH\Bundle\SubscriptionBundle\Event\OrderEvent;
use PH\Bundle\SubscriptionBundle\Model\OrderInterface;
use PH\Bundle\SubscriptionBundle\OrderEvents;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
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
     * OrderService constructor.
     *
     * @param FactoryInterface                   $orderItemFactory
     * @param OrderItemQuantityModifierInterface $orderItemQuantityModifier
     */
    public function __construct(
        FactoryInterface $orderItemFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->orderItemFactory = $orderItemFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function prepareOrder(OrderInterface $order, array $data): OrderInterface
    {
        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemFactory->createNew();
        $this->orderItemQuantityModifier->modify($orderItem, 1);
        $orderItem->setUnitPrice((int) $data['amount']);

        $order->addItem($orderItem);
        $order->recalculateItemsTotal();
        $order->completeCheckout();
        $order->setProviderType($data['providerType']);

        return $order;
    }

    public function updateOrder(OrderInterface $order, array $data): OrderInterface
    {
        $this->eventDispatcher->dispatch(OrderEvents::ORDER_UPDATE, new OrderEvent($order));

        return $order;
    }
}
