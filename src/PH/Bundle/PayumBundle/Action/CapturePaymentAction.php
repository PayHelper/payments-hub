<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\Payment as PayumPayment;
use Payum\Core\Request\Capture;
use Payum\Core\Request\Convert;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;

final class CapturePaymentAction extends GatewayAwareAction
{
    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getModel();
        $paymentMethodConfig = $payment->getMethod()->getGatewayConfig()->getConfig();

        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        $this->gateway->execute($status = new GetStatus($payment));

        if ($status->isNew()) {
            try {
                $this->gateway->execute($convert = new Convert($payment, 'array', $request->getToken()));
                $payment->setDetails($convert->getResult());
            } catch (RequestNotSupportedException $e) {
                $totalAmount = $order->getTotal();
                $payumPayment = new PayumPayment();
                $payumPayment->setNumber($order->getNumber());
                $payumPayment->setTotalAmount($totalAmount);
                $payumPayment->setCurrencyCode($order->getCurrencyCode());
                $payumPayment->setDescription($order->getItems()->first()->getSubscription()->getName());

                $startDate = $order->getItems()->first()->getSubscription()->getStartDate();
                if (null === $startDate) {
                    $startDate = new \DateTime();
                }

                $details = [
                    'interval' => $order->getItems()->first()->getSubscription()->getInterval(),
                    'startDate' => $startDate->format('Y-m-d'),
                ];

                if (isset($paymentMethodConfig['method'])) {
                    $details['method'] = $paymentMethodConfig['method'];
                }

                $payumPayment->setDetails(array_merge($payment->getDetails(), $details));

                $this->gateway->execute($convert = new Convert($payumPayment, 'array', $request->getToken()));

                $payment->setDetails($convert->getResult());
            }
        }

        $details = ArrayObject::ensureArrayObject($payment->getDetails());

        try {
            $request->setModel($details);
            $this->gateway->execute($request);
        } finally {
            $payment->setDetails((array) $details);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof PaymentInterface
        ;
    }
}
