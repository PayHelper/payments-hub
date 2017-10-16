<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Factory;

use PH\Bundle\PayumBundle\Request\ResolveNextUrl;
use PH\Bundle\PayumBundle\Request\ResolveNextUrlInterface;

final class ResolveNextUrlFactory implements ResolveNextUrlFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNewWithModel($model): ResolveNextUrlInterface
    {
        return new ResolveNextUrl($model);
    }
}
