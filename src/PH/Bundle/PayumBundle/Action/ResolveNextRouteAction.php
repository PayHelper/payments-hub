<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action;

use Payum\Core\Action\ActionInterface;
use PH\Bundle\PayumBundle\Request\ResolveNextRoute;
use PH\Component\Core\Model\PaymentInterface;

final class ResolveNextRouteAction implements ActionInterface
{
    /**
     * {@inheritdoc}
     *
     * @param ResolveNextRoute $request
     */
    public function execute($request): void
    {
        /** @var PaymentInterface $payment */
        $payment = $request->getFirstModel();

        if (
            $payment->getState() === PaymentInterface::STATE_COMPLETED ||
            $payment->getState() === PaymentInterface::STATE_AUTHORIZED ||
            $payment->getState() === PaymentInterface::STATE_PROCESSING
        ) {
            $request->setRouteName('ph_core_thankyou');
            $request->setRouteParameters(['token' => $payment->getSubscription()->getTokenValue()]);

            return;
        }

        $request->setRouteName('ph_core_cancel');
        $request->setRouteParameters(['token' => $payment->getSubscription()->getTokenValue()]);
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
