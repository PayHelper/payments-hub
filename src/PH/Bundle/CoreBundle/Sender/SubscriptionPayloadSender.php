<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Sender;

use GuzzleHttp\Client;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Webhook\Model\WebhookInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class SubscriptionPayloadSender implements SubscriptionPayloadSenderInterface
{
    /**
     * @var RepositoryInterface
     */
    private $webhookRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * SubscriptionPayloadSender constructor.
     *
     * @param RepositoryInterface $webhookRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(RepositoryInterface $webhookRepository, SerializerInterface $serializer)
    {
        $this->webhookRepository = $webhookRepository;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function send(SubscriptionInterface $subscription): void
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        /** @var WebhookInterface[] $destinations */
        $destinations = $this->webhookRepository->findAll();

        $client = new Client();
        /** @var WebhookInterface $destination */
        foreach ($destinations as $destination) {
            $client->request('POST', $destination->getUrl(), [
                'body' => $this->serializer->serialize($subscription, 'json', $context),
            ]);
        }
    }
}
