<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Provider;

use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use Symfony\Component\Translation\TranslatorInterface;

final class PaymentDescriptionProvider implements PaymentDescriptionProviderInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentDescription(PaymentInterface $payment): string
    {
        /** @var SubscriptionInterface $subscription */
        $subscription = $payment->getSubscription();

        return $this->translator->trans('ph.payum_action.payment.description', [
            '%total%' => round($subscription->getTotal() / 100, 2),
            '%currency%' => $subscription->getCurrencyCode(),
        ]);
    }
}
