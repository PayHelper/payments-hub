<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Form\Extension;

use Sylius\Bundle\PayumBundle\Form\Type\PaypalGatewayConfigurationType;

final class PaypalGatewayConfigurationExtensionType extends AbstractGatewayConfigurationExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return PaypalGatewayConfigurationType::class;
    }
}
