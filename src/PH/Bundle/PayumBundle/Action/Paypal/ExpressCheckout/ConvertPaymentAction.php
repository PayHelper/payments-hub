<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Paypal\ExpressCheckout;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use PH\Bundle\PayumBundle\Provider\PaymentDescriptionProviderInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;

final class ConvertPaymentAction implements ActionInterface
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
     *
     * @param Convert $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        /** @var SubscriptionInterface $subscription */
        $subscription = $payment->getSubscription();

        $details = [];
        $details['PAYMENTREQUEST_0_INVNUM'] = $subscription->getId().'-'.$payment->getId();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = $subscription->getCurrencyCode();
        $details['PAYMENTREQUEST_0_AMT'] = $this->formatPrice($subscription->getTotal());
        $details['PAYMENTREQUEST_0_ITEMAMT'] = $this->formatPrice($subscription->getTotal());

        $m = 0;
        foreach ($subscription->getItems() as $item) {
            $details['L_PAYMENTREQUEST_0_NAME'.$m] = $this->descriptionProvider->getPaymentDescription($payment);
            $details['L_PAYMENTREQUEST_0_AMT'.$m] = $this->formatPrice($item->getUnitPrice());
            $details['L_PAYMENTREQUEST_0_QTY'.$m] = $item->getQuantity();

            ++$m;
        }

        $request->setResult($details);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            'array' === $request->getTo()
        ;
    }

    /**
     * @param int $price
     *
     * @return float
     */
    private function formatPrice(int $price)
    {
        return round($price / 100, 2);
    }
}
