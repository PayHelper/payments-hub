<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Factory;

use PH\Bundle\PayumBundle\Request\ResolveNextRouteInterface;

interface ResolveNextRouteFactoryInterface
{
    /**
     * @param $model
     *
     * @return ResolveNextRouteInterface
     */
    public function createNewWithModel($model): ResolveNextRouteInterface;
}
