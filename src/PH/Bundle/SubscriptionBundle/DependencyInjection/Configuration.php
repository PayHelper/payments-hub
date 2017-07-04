<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\DependencyInjection;

use PH\Bundle\SubscriptionBundle\Form\Type\SubscriptionType;
use PH\Component\Subscription\Model\Subscription;
use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ph_subscription');

        $rootNode
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                ->end()
        ;

        $this->addResources($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addResources(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('resources')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('subscription')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('options')->end()
                        ->arrayNode('classes')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(Subscription::class)->cannotBeEmpty()->end()
                                ->scalarNode('interface')->defaultValue(SubscriptionInterface::class)->cannotBeEmpty()->end()
                                ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                ->scalarNode('repository')->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                ->scalarNode('form')->defaultValue(SubscriptionType::class)->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->end()
                ->end()
                ->end()
            ->end()
        ;
    }
}
