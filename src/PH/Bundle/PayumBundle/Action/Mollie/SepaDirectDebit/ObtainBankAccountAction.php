<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Mollie\SepaDirectDebit;

use PayHelper\Payum\Mollie\Request\Api\CreateSepaMandate;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Model\BankAccountInterface;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Security\SensitiveValue;
use PH\Bundle\PayumBundle\Request\ObtainBankAccount;

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

        // process confirm form if submitted
        $this->gateway->execute($httpRequest = new GetHttpRequest());

        if ('POST' === $httpRequest->method) {
            $postParams = [];
            parse_str($httpRequest->content, $postParams);

            if (array_key_exists('mandate_id', $postParams) && null !== $postParams['mandate_id'] && $postParams['mandate_id'] === $model['mandate']['id']) {
                // mandate has been confirmed by the user
                return;
            }
        }

        if (!$model->validateNotEmpty(['sepaIban', 'sepaHolder'], false)) {
            try {
                $obtainBankAccount = new ObtainBankAccount($request->getToken());
                $obtainBankAccount->setModel($request->getModel());
                $this->gateway->execute($obtainBankAccount);

                /** @var BankAccountInterface $bankAccount */
                $bankAccount = $obtainBankAccount->obtain();

                $model['sepaIban'] = SensitiveValue::ensureSensitive($bankAccount->getIban());
                $model['sepaHolder'] = SensitiveValue::ensureSensitive($bankAccount->getHolder());

                $this->gateway->execute(new CreateSepaMandate($model));
            } catch (RequestNotSupportedException $e) {
                throw new LogicException('Bank account details has to be set explicitly or there has to be an action that supports ObtainBankAccount request.');
            }
        }
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
