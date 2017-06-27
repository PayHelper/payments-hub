<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle;

use PH\Bundle\PayumBundle\DependencyInjection\Compiler\OverridePaymentStateExtension;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PHPayumBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new OverridePaymentStateExtension());
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'PH\Bundle\PayumBundle\Model';
    }
}
