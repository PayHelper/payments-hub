<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use PH\Bundle\CoreBundle\Facade\OrderFacadeInterface;
use PH\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class OrderContext implements Context
{
    /**
     * @var \PH\Bundle\CoreBundle\Facade\OrderFacadeInterface
     */
    private $orderService;

    /**
     * @var FactoryInterface
     */
    private $orderFactory;

    /**
     * @var RepositoryInterface
     */
    private $orderRepository;

    /**
     * @var FactoryInterface
     */
    private $subscriptionFactory;

    /**
     * OrderContext constructor.
     *
     * @param OrderFacadeInterface $orderService
     * @param FactoryInterface     $orderFactory
     * @param RepositoryInterface  $orderRepository
     * @param FactoryInterface     $subscriptionFactory
     */
    public function __construct(
        OrderFacadeInterface $orderService,
        FactoryInterface $orderFactory,
        RepositoryInterface $orderRepository,
        FactoryInterface $subscriptionFactory
    ) {
        $this->orderService = $orderService;
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        $this->subscriptionFactory = $subscriptionFactory;
    }

    /**
     * @Given /^the system has(?:| also) a new subscription priced at ("[^"]+")$/
     */
    public function theSystemHasAlsoANewSubscriptionPricedAt(string $price)
    {
        $currencyCode = 'USD';
        $order = $this->createOrder(
            $this->getPriceFromString(str_replace(['$', '"'], '', $price)),
            $currencyCode
        );

        $this->orderRepository->add($order);
    }

    private function createOrder(int $price, string $currencyCode)
    {
        /** @var OrderInterface $order */
        $order = $this->orderFactory->createNew();
        /** @var \PH\Component\Subscription\Model\SubscriptionInterface $subscription */
        $subscription = $this->subscriptionFactory->createNew();
        $subscription->setAmount($price);
        $subscription->setCurrencyCode($currencyCode);
        $order->setTokenValue('12345abcde');

        return  $this->orderService->prepareOrder($order, $subscription);
    }

    private function getPriceFromString(string $price)
    {
        return (int) round((int) $price * 100, 2);
    }
}
