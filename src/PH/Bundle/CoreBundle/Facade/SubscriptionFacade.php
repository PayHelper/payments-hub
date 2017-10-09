<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Facade;

use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Processor\SubscriptionProcessorInterface;
use PH\Component\Subscription\Model\SubscriptionItemInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class SubscriptionFacade implements SubscriptionFacadeInterface
{
    /**
     * @var FactoryInterface
     */
    private $subscriptionItemFactory;

    private $subscriptionProcessor;

    /**
     * SubscriptionFacade constructor.
     *
     * @param FactoryInterface               $subscriptionItemFactory
     * @param SubscriptionProcessorInterface $subscriptionProcessor
     */
    public function __construct(FactoryInterface $subscriptionItemFactory, SubscriptionProcessorInterface $subscriptionProcessor)
    {
        $this->subscriptionItemFactory = $subscriptionItemFactory;
        $this->subscriptionProcessor = $subscriptionProcessor;
    }

    public function prepareSubscription(SubscriptionInterface $subscription): SubscriptionInterface
    {
        /** @var SubscriptionItemInterface $subscriptionItem */
        $subscriptionItem = $this->subscriptionItemFactory->createNew();

        $subscriptionItem->setUnitPrice($subscription->getAmount());
        $subscriptionItem->setTotal($subscription->getAmount());
        $subscription->addItem($subscriptionItem);

        $subscription->recalculateItemsTotal();

        $this->subscriptionProcessor->process($subscription);

        return $subscription;
    }
}
