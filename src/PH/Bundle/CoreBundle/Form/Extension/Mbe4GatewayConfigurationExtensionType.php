<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Form\Extension;

use PH\Bundle\PayumBundle\Form\Type\Mbe4GatewayConfigurationType;

final class Mbe4GatewayConfigurationExtensionType extends AbstractGatewayConfigurationExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return Mbe4GatewayConfigurationType::class;
    }
}
