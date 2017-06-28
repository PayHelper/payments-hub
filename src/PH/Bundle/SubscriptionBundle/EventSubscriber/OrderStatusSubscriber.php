<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\EventSubscriber;

use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use PH\Bundle\SubscriptionBundle\Event\OrderEvent;
use PH\Component\Webhook\Model\WebhookInterface;
use PH\Bundle\SubscriptionBundle\OrderEvents;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class OrderStatusSubscriber implements EventSubscriberInterface
{
    /**
     * @var RepositoryInterface
     */
    private $pushDestinationsRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(RepositoryInterface $pushDestinationsRepository, SerializerInterface $serializer)
    {
        $this->pushDestinationsRepository = $pushDestinationsRepository;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            OrderEvents::ORDER_CREATE => 'sendNotifications',
            OrderEvents::ORDER_UPDATE => 'sendNotifications',
        ];
    }

    /**
     * @param OrderEvent $event
     */
    public function sendNotifications(OrderEvent $event)
    {
        $destinations = $this->pushDestinationsRepository->findAll();

        $client = new Client();
        /** @var \PH\Component\Webhook\Model\WebhookInterface $destination */
        foreach ($destinations as $destination) {
            $result = $client->request('POST', $destination->getUrl(), [
                'body' => $this->serializer->serialize($event->getOrder(), 'json'),
            ]);
            dump($result);
        }
    }
}
