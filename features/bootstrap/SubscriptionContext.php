<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use PH\Bundle\CoreBundle\Facade\SubscriptionFacadeInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Subscription\Model\MetadataInterface;
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
     * @var FactoryInterface
     */
    private $subscriptionMetadataFactory;

    /**
     * @var SubscriptionInterface
     */
    private $subscription;

    /**
     * SubscriptionContext constructor.
     *
     * @param SubscriptionFacadeInterface $subscriptionFacade
     * @param FactoryInterface            $subscriptionFactory
     * @param RepositoryInterface         $subscriptionRepository
     * @param FactoryInterface            $subscriptionMetadataFactory
     */
    public function __construct(
        SubscriptionFacadeInterface $subscriptionFacade,
        FactoryInterface $subscriptionFactory,
        RepositoryInterface $subscriptionRepository,
        FactoryInterface $subscriptionMetadataFactory
    ) {
        $this->subscriptionFacade = $subscriptionFacade;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionMetadataFactory = $subscriptionMetadataFactory;
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

    /**
     * @Then this subscription should( also) have metadata :name with value :value
     */
    public function thisSubscriptionShouldHaveMetadataWithValue(string $name, string $value)
    {
        /** @var MetadataInterface $subscriptionMetadata */
        $subscriptionMetadata = $this->subscriptionMetadataFactory->createNew();
        $subscriptionMetadata->setKey($name);
        $subscriptionMetadata->setValue($value);

        $this->subscription->addMetadata($subscriptionMetadata);

        $this->subscriptionRepository->add($this->subscription);
    }

    private function createSubscription(int $price, string $currencyCode)
    {
        /** @var SubscriptionInterface $subscription */
        $subscription = $this->subscriptionFactory->createNew();
        $subscription->setAmount($price);
        $subscription->setCurrencyCode($currencyCode);
        $subscription->setTokenValue('12345abcde');

        $this->subscription = $this->subscriptionFacade->prepareSubscription($subscription);

        return $this->subscription;
    }

    private function getPriceFromString(string $price)
    {
        return (int) round((int) $price * 100, 2);
    }
}
