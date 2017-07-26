<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Sender;

use GuzzleHttp\Client;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Webhook\Model\WebhookInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class OrderPayloadSender implements OrderPayloadSenderInterface
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
     * OrderPayloadSender constructor.
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
    public function send(OrderInterface $order): void
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        /** @var WebhookInterface[] $destinations */
        $destinations = $this->webhookRepository->findAll();

        $client = new Client();
        /** @var WebhookInterface $destination */
        foreach ($destinations as $destination) {
            $client->request('POST', $destination->getUrl(), [
                'body' => $this->serializer->serialize($order, 'json', $context),
            ]);
        }
    }
}
