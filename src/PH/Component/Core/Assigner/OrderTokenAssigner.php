<?php

declare(strict_types=1);

namespace PH\Component\Core\Assigner;

use PH\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Generator\RandomnessGeneratorInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class OrderTokenAssigner implements OrderTokenAssignerInterface
{
    /**
     * @var RandomnessGeneratorInterface
     */
    private $generator;

    /**
     * @param RandomnessGeneratorInterface $generator
     */
    public function __construct(RandomnessGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param OrderInterface $order
     */
    public function assignTokenValue(OrderInterface $order): void
    {
        $order->setTokenValue($this->generator->generateUriSafeString(10));
    }
}
