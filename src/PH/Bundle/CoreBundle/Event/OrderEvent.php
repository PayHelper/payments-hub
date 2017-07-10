<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Event;

use PH\Component\Core\Model\OrderInterface;
use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * OrderEvent constructor.
     *
     * @param OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }
}
