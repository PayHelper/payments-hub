<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\EventSubscriber;

use PH\Bundle\CoreBundle\Sender\OrderPayloadSenderInterface;
use PH\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\GenericEvent;

final class SendOrderPayloadListener
{
    /**
     * @var OrderPayloadSenderInterface
     */
    private $orderPayloadSender;

    /**
     * SendOrderPayloadListener constructor.
     *
     * @param OrderPayloadSenderInterface $orderPayloadSender
     */
    public function __construct(OrderPayloadSenderInterface $orderPayloadSender)
    {
        $this->orderPayloadSender = $orderPayloadSender;
    }

    /**
     * @param GenericEvent $event
     */
    public function sendPayload(GenericEvent $event)
    {
        if (!($subject = $event->getSubject()) instanceof OrderInterface) {
            throw new UnexpectedTypeException($subject, OrderInterface::class);
        }

        $this->orderPayloadSender->send($subject);
    }
}
