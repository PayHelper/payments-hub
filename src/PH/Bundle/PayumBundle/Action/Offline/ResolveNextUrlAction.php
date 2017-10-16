<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Offline;

use Payum\Core\Action\ActionInterface;
use PH\Bundle\PayumBundle\Request\ResolveNextUrl;
use Sylius\Component\Payment\Model\PaymentInterface;

final class ResolveNextUrlAction implements ActionInterface
{
    /**
     * @var string
     */
    private $thankYouUrl;

    /**
     * ResolveNextUrlAction constructor.
     *
     * @param string $thankYouUrl
     */
    public function __construct(string $thankYouUrl)
    {
        $this->thankYouUrl = $thankYouUrl;
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
        $request->setUrl($this->thankYouUrl);
        $request->setUrlQueryParams(['token' => $payment->getSubscription()->getTokenValue()]);
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
