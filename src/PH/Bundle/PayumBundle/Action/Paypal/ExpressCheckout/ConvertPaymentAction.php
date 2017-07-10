<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Paypal\ExpressCheckout;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Payment\InvoiceNumberGeneratorInterface;

final class ConvertPaymentAction implements ActionInterface
{
    /**
     * @var InvoiceNumberGeneratorInterface
     */
    private $invoiceNumberGenerator;

    /**
     * @param InvoiceNumberGeneratorInterface $invoiceNumberGenerator
     */
    public function __construct(
        InvoiceNumberGeneratorInterface $invoiceNumberGenerator
    ) {
        $this->invoiceNumberGenerator = $invoiceNumberGenerator;
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
        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        $details = [];
        $details['PAYMENTREQUEST_0_INVNUM'] = $this->invoiceNumberGenerator->generate($order, $payment);
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = $order->getCurrencyCode();
        $details['PAYMENTREQUEST_0_AMT'] = $this->formatPrice($order->getTotal());
        $details['PAYMENTREQUEST_0_ITEMAMT'] = $this->formatPrice($order->getTotal());

        $m = 0;
        foreach ($order->getItems() as $item) {
            $details['L_PAYMENTREQUEST_0_NAME'.$m] = $order->getItems()->first()->getSubscription()->getName();
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
            $request->getTo() === 'array'
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
