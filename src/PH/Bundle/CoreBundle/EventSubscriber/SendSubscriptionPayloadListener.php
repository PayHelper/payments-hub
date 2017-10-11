<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\EventSubscriber;

use PH\Bundle\CoreBundle\Sender\SubscriptionPayloadSenderInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\GenericEvent;

final class SendSubscriptionPayloadListener
{
    /**
     * @var SubscriptionPayloadSenderInterface
     */
    private $subscriptionPayloadSender;

    /**
     * SendSubscriptionPayloadListener constructor.
     *
     * @param SubscriptionPayloadSenderInterface $subscriptionPayloadSender
     */
    public function __construct(SubscriptionPayloadSenderInterface $subscriptionPayloadSender)
    {
        $this->subscriptionPayloadSender = $subscriptionPayloadSender;
    }

    /**
     * @param GenericEvent $event
     *
     * @throws \Sylius\Component\Resource\Exception\UnexpectedTypeException
     */
    public function sendPayload(GenericEvent $event)
    {
        if (!($subject = $event->getSubject()) instanceof SubscriptionInterface) {
            throw new UnexpectedTypeException($subject, SubscriptionInterface::class);
        }

        $this->subscriptionPayloadSender->send($subject);
    }
}
