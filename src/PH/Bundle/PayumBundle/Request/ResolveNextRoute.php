<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Request;

use Payum\Core\Request\Generic;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
class ResolveNextRoute extends Generic implements ResolveNextRouteInterface
{
    /**
     * @var string
     */
    private $routeName;

    /**
     * @var array
     */
    private $routeParameters = [];

    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    public function setRouteName(string $routeName): void
    {
        $this->routeName = $routeName;
    }

    public function getRouteParameters(): array
    {
        return $this->routeParameters;
    }

    public function setRouteParameters(array $parameters): void
    {
        $this->routeParameters = $parameters;
    }
}
