<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\EventSubscriber;

use GuzzleHttp\Client;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Webhook\Model\WebhookInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final class SendOrderPayloadListener
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
     * SendOrderPayloadListener constructor.
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
     * @param GenericEvent $event
     */
    public function sendPayload(GenericEvent $event)
    {
        if (!($subject = $event->getSubject()) instanceof OrderInterface) {
            throw new UnexpectedTypeException($subject, OrderInterface::class);
        }

        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $destinations = $this->webhookRepository->findAll();

        $client = new Client();
        /** @var WebhookInterface $destination */
        foreach ($destinations as $destination) {
            $client->request('POST', $destination->getUrl(), [
                'payload' => $this->serializer->serialize($subject, 'json', $context),
            ]);
        }
    }
}
