<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Factory;

use PH\Bundle\PayumBundle\Request\ResolveNextRoute;
use PH\Bundle\PayumBundle\Request\ResolveNextRouteInterface;

final class ResolveNextRouteFactory implements ResolveNextRouteFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNewWithModel($model): ResolveNextRouteInterface
    {
        return new ResolveNextRoute($model);
    }
}
