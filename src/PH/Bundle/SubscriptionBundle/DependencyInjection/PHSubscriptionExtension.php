<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class PHSubscriptionExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $this->registerResources('ph', $config['driver'], $config['resources'], $container);
        $loader->load('forms.yml');
        $loader->load('services.yml');

        $container->setParameter(
            $this->getAlias().'.date_time_helper.class',
            $config['date_time_helper']
        );

        $container->setParameter($this->getAlias().'.subscription_intervals', $config['subscription_intervals']);
    }
}
