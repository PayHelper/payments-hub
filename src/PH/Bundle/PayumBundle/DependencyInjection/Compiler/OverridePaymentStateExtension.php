<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\DependencyInjection\Compiler;

use PH\Bundle\PayumBundle\Extension\UpdatePaymentStateExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;

class OverridePaymentStateExtension implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->overrideDefinitionClassIfExists(
            $container,
            'sylius.payum_extension.update_payment_state',
            UpdatePaymentStateExtension::class
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $serviceId
     * @param string           $classNamespace
     *
     * @return Definition
     */
    public function overrideDefinitionClassIfExists(
        ContainerBuilder $container,
        string $serviceId,
        string $classNamespace
    ) {
        /** @var Definition $definition */
        if (null === $definition = $this->getDefinitionIfExists($container, $serviceId)) {
            return;
        }

        $definition->setClass($classNamespace);

        return $definition;
    }

    /**
     * @param ContainerBuilder $container
     * @param $serviceId
     *
     * @return Definition|void
     */
    public function getDefinitionIfExists(ContainerBuilder $container, $serviceId)
    {
        if (!$container->hasDefinition($serviceId)) {
            return;
        }

        return $container->getDefinition($serviceId);
    }
}
