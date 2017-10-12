<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Offline;

use Payum\Core\Action\ActionInterface;
use PH\Bundle\PayumBundle\Request\ResolveNextRoute;
use Sylius\Component\Payment\Model\PaymentInterface;

final class ResolveNextRouteAction implements ActionInterface
{
    /**
     * {@inheritdoc}
     *
     * @param ResolveNextRoute $request
     */
    public function execute($request): void
    {
        $request->setRouteName('ph_core_thankyou');
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request): bool
    {
        return
            $request instanceof ResolveNextRoute &&
            $request->getFirstModel() instanceof PaymentInterface
        ;
    }
}
