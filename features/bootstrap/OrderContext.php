<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use PH\Bundle\SubscriptionBundle\Service\OrderServiceInterface;
use PH\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class OrderContext implements Context
{
    /**
     * @var OrderServiceInterface
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
     * OrderContext constructor.
     *
     * @param OrderServiceInterface $orderService
     * @param FactoryInterface      $orderFactory
     * @param RepositoryInterface   $orderRepository
     */
    public function __construct(
        OrderServiceInterface $orderService,
        FactoryInterface $orderFactory,
        RepositoryInterface $orderRepository
    ) {
        $this->orderService = $orderService;
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Given /^the system has(?:| also) a new order priced at ("[^"]+")$/
     */
    public function theSystemHasANewOrderPricedAt(string $price)
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

        return $this->orderService->prepareOrder($order, ['price' => $price, 'currencyCode' => $currencyCode]);
    }

    private function getPriceFromString(string $price)
    {
        return (int) round((int) $price * 100, 2);
    }
}
