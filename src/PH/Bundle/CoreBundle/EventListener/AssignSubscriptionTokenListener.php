<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\EventListener;

use PH\Component\Core\Assigner\SubscriptionTokenAssignerInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\GenericEvent;

final class AssignSubscriptionTokenListener
{
    /**
     * @var SubscriptionTokenAssignerInterface
     */
    private $subscriptionTokenAssigner;

    public function __construct(SubscriptionTokenAssignerInterface $subscriptionTokenAssigner)
    {
        $this->subscriptionTokenAssigner = $subscriptionTokenAssigner;
    }

    /**
     * @param GenericEvent $event
     *
     * @throws \Sylius\Component\Resource\Exception\UnexpectedTypeException
     */
    public function assignToken(GenericEvent $event)
    {
        if (!($subject = $event->getSubject()) instanceof SubscriptionInterface) {
            throw new UnexpectedTypeException($subject, SubscriptionInterface::class);
        }

        $this->subscriptionTokenAssigner->assignTokenValue($subject);
    }
}
