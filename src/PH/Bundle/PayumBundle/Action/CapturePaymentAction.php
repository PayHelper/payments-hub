<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\Payment as PayumPayment;
use Payum\Core\Request\Capture;
use Payum\Core\Request\Convert;
use PH\Bundle\PayumBundle\Provider\PaymentDescriptionProviderInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;

final class CapturePaymentAction extends GatewayAwareAction
{
    /**
     * @var PaymentDescriptionProviderInterface
     */
    private $descriptionProvider;

    /**
     * CapturePaymentAction constructor.
     *
     * @param PaymentDescriptionProviderInterface $descriptionProvider
     */
    public function __construct(PaymentDescriptionProviderInterface $descriptionProvider)
    {
        $this->descriptionProvider = $descriptionProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getModel();
        $paymentMethodConfig = $payment->getMethod()->getGatewayConfig()->getConfig();

        /** @var SubscriptionInterface $subscription */
        $subscription = $payment->getSubscription();

        $this->gateway->execute($status = new GetStatus($payment));

        if ($status->isNew()) {
            try {
                $this->gateway->execute($convert = new Convert($payment, 'array', $request->getToken()));
                $payment->setDetails($convert->getResult());
            } catch (RequestNotSupportedException $e) {
                $totalAmount = $subscription->getTotal();
                $payumPayment = new PayumPayment();
                //$payumPayment->setNumber($subscription->getNumber());
                $payumPayment->setTotalAmount($totalAmount);
                $payumPayment->setCurrencyCode($subscription->getCurrencyCode());
                $payumPayment->setDescription($this->descriptionProvider->getPaymentDescription($payment));

                $startDate = $subscription->getStartDate();
                if (null === $startDate) {
                    $startDate = new \DateTime();
                }

                $details = [
                    'interval' => $subscription->getInterval(),
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
