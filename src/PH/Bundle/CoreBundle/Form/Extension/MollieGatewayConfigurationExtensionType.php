<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Form\Extension;

use PH\Bundle\PayumBundle\Form\Type\MollieGatewayConfigurationType;

final class MollieGatewayConfigurationExtensionType extends AbstractGatewayConfigurationExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return MollieGatewayConfigurationType::class;
    }
}
