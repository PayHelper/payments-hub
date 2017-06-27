<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Model;

use Payum\Core\Model\GatewayConfig as BaseGatewayConfig;
use Sylius\Component\Resource\Model\ResourceInterface;

class GatewayConfig extends BaseGatewayConfig implements ResourceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
