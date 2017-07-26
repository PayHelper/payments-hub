<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Sender;

use PH\Component\Core\Model\OrderInterface;

interface OrderPayloadSenderInterface
{
    /**
     * @param OrderInterface $order
     */
    public function send(OrderInterface $order): void;
}
