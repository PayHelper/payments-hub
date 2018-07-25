<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle;

use PH\Bundle\SubscriptionBundle\DependencyInjection\Compiler\RegisterDateTimeHelperCompilerPass;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PHSubscriptionBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterDateTimeHelperCompilerPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace(): ?string
    {
        return 'PH\Component\Subscription\Model';
    }
}
