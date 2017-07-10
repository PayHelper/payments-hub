<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Facade;

use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\OrderItemInterface;
use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class OrderFacade implements OrderFacadeInterface
{
    /**
     * @var FactoryInterface
     */
    private $orderItemFactory;

    /**
     * @var OrderItemQuantityModifierInterface
     */
    private $orderItemQuantityModifier;

    /**
     * @var OrderModifierInterface
     */
    private $orderModifier;

    /**
     * OrderFacade constructor.
     *
     * @param FactoryInterface                   $orderItemFactory
     * @param OrderItemQuantityModifierInterface $orderItemQuantityModifier
     * @param OrderModifierInterface             $orderModifier
     */
    public function __construct(
        FactoryInterface $orderItemFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        OrderModifierInterface $orderModifier
    ) {
        $this->orderItemFactory = $orderItemFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->orderModifier = $orderModifier;
    }

    public function prepareOrder(OrderInterface $order, SubscriptionInterface $subscription): OrderInterface
    {
        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemFactory->createNew();

        $this->orderItemQuantityModifier->modify($orderItem, 1);
        $orderItem->setUnitPrice($subscription->getAmount());
        $orderItem->setSubscription($subscription);
        $order->setCurrencyCode($subscription->getCurrencyCode());
        $this->orderModifier->addToOrder($order, $orderItem);

        $order->recalculateItemsTotal();

        return $order;
    }
}
