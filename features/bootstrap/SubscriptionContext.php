<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use PH\Bundle\CoreBundle\Facade\SubscriptionFacadeInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class SubscriptionContext implements Context
{
    /**
     * @var SubscriptionFacadeInterface
     */
    private $subscriptionFacade;

    /**
     * @var FactoryInterface
     */
    private $subscriptionFactory;

    /**
     * @var RepositoryInterface
     */
    private $subscriptionRepository;

    /**
     * SubscriptionContext constructor.
     *
     * @param SubscriptionFacadeInterface $subscriptionFacade
     * @param FactoryInterface            $subscriptionFactory
     * @param RepositoryInterface         $subscriptionRepository
     */
    public function __construct(
        SubscriptionFacadeInterface $subscriptionFacade,
        FactoryInterface $subscriptionFactory,
        RepositoryInterface $subscriptionRepository
    ) {
        $this->subscriptionFacade = $subscriptionFacade;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionFactory = $subscriptionFactory;
    }

    /**
     * @Given /^the system has(?:| also) a new subscription priced at ("[^"]+")$/
     */
    public function theSystemHasAlsoANewSubscriptionPricedAt(string $price)
    {
        $currencyCode = 'USD';
        $subscription = $this->createSubscription(
            $this->getPriceFromString(str_replace(['$', '"'], '', $price)),
            $currencyCode
        );

        $this->subscriptionRepository->add($subscription);
    }

    private function createSubscription(int $price, string $currencyCode)
    {
        /** @var SubscriptionInterface $subscription */
        $subscription = $this->subscriptionFactory->createNew();
        $subscription->setAmount($price);
        $subscription->setCurrencyCode($currencyCode);
        $subscription->setTokenValue('12345abcde');

        return  $this->subscriptionFacade->prepareSubscription($subscription);
    }

    private function getPriceFromString(string $price)
    {
        return (int) round((int) $price * 100, 2);
    }
}
