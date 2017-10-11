<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class RegisterDateTimeHelperCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('ph.helper.date_time')) {
            return;
        }

        $container->register('ph.helper.date_time', $container->getParameter('ph_subscription.date_time_helper.class'));
    }
}
