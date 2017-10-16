<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Factory;

use PH\Bundle\PayumBundle\Request\ResolveNextUrlInterface;

interface ResolveNextUrlFactoryInterface
{
    /**
     * @param $model
     *
     * @return ResolveNextUrlInterface
     */
    public function createNewWithModel($model): ResolveNextUrlInterface;
}
