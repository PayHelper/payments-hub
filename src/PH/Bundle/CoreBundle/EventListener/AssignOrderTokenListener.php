<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\EventListener;

use PH\Component\Core\Assigner\OrderTokenAssignerInterface;
use PH\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\GenericEvent;

final class AssignOrderTokenListener
{
    /**
     * @var OrderTokenAssignerInterface
     */
    private $orderTokenAssigner;

    public function __construct(OrderTokenAssignerInterface $orderTokenAssigner)
    {
        $this->orderTokenAssigner = $orderTokenAssigner;
    }

    /**
     * @param GenericEvent $event
     */
    public function assignToken(GenericEvent $event)
    {
        if (!($subject = $event->getSubject()) instanceof OrderInterface) {
            throw new UnexpectedTypeException($subject, OrderInterface::class);
        }

        $this->orderTokenAssigner->assignTokenValue($subject);
    }
}
