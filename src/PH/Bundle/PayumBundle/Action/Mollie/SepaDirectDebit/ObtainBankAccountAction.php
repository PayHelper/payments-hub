<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Mollie\SepaDirectDebit;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\RenderTemplate;
use Payum\Core\Security\SensitiveValue;
use Sourcefabric\Payum\Mollie\Request\Api\CreateSepaMandate;

class ObtainBankAccountAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * @var string
     */
    protected $templateName;

    /**
     * ObtainBankAccount constructor.
     *
     * @param string $templateName
     */
    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $this->gateway->execute($httpRequest = new GetHttpRequest());

        if ('POST' === $httpRequest->method) {
            $postParams = [];
            parse_str($httpRequest->content, $postParams);

            if (!isset($postParams['sepa_iban'])) {
                return;
            }

            if (!isset($postParams['sepa_holder'])) {
                return;
            }

            $model['sepaIban'] = SensitiveValue::ensureSensitive($postParams['sepa_iban']);
            $model['sepaHolder'] = SensitiveValue::ensureSensitive($postParams['sepa_holder']);

            $this->gateway->execute(new CreateSepaMandate($model));

            return;
        }

        // obtain iban and holder name
        $this->gateway->execute($renderTemplate = new RenderTemplate($this->templateName, [
            'actionUrl' => $request->getToken() ? $request->getToken()->getTargetUrl() : null,
        ]));

        throw new HttpResponse($renderTemplate->getResult());
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof CreateSepaMandate &&
            $request->getModel() instanceof \ArrayAccess &&
            \Mollie_API_Object_Method::DIRECTDEBIT === $request->getModel()['method'] &&
            !isset($request->getModel()['sepaIban']) &&
            !isset($request->getModel()['sepaHolder']);
    }
}
