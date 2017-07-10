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
use Sylius\Bundle\PayumBundle\Provider\PaymentDescriptionProviderInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;

final class CapturePaymentAction extends GatewayAwareAction
{
    /**
     * @var PaymentDescriptionProviderInterface
     */
    private $paymentDescriptionProvider;

    /**
     * @param PaymentDescriptionProviderInterface $paymentDescriptionProvider
     */
    public function __construct(PaymentDescriptionProviderInterface $paymentDescriptionProvider)
    {
        $this->paymentDescriptionProvider = $paymentDescriptionProvider;
    }

    /**
     * {@inheritdoc}
     *
     * @param $request Capture
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getModel();

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
                $payumPayment->setDescription($this->paymentDescriptionProvider->getPaymentDescription($payment));
                $payumPayment->setDetails($payment->getDetails());

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
