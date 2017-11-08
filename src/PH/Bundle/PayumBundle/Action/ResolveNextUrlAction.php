<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action;

use Payum\Core\Action\ActionInterface;
use PH\Bundle\PayumBundle\Request\ResolveNextUrl;
use PH\Component\Core\Model\PaymentInterface;

final class ResolveNextUrlAction implements ActionInterface
{
    /**
     * @var string
     */
    private $thankYouUrl;

    /**
     * @var string
     */
    private $cancelUrl;

    /**
     * ResolveNextUrlAction constructor.
     *
     * @param string $thankYouUrl
     * @param string $cancelUrl
     */
    public function __construct(string $thankYouUrl, string $cancelUrl)
    {
        $this->thankYouUrl = $thankYouUrl;
        $this->cancelUrl = $cancelUrl;
    }

    /**
     * {@inheritdoc}
     *
     * @param ResolveNextUrl $request
     */
    public function execute($request): void
    {
        /** @var PaymentInterface $payment */
        $payment = $request->getFirstModel();

        if (
            PaymentInterface::STATE_COMPLETED === $payment->getState() ||
            PaymentInterface::STATE_AUTHORIZED === $payment->getState() ||
            PaymentInterface::STATE_PROCESSING === $payment->getState()
        ) {
            $request->setUrl($this->thankYouUrl);

            $params = ['token' => $payment->getSubscription()->getTokenValue()];

            if (isset($payment->getDetails()['email']) && null !== ($email = $payment->getDetails()['email'])) {
                $params['email'] = $email;
            }

            $request->setUrlQueryParams($params);

            return;
        }

        $request->setUrl($this->cancelUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request): bool
    {
        return
            $request instanceof ResolveNextUrl &&
            $request->getFirstModel() instanceof PaymentInterface
        ;
    }
}
