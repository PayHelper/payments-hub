<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action\Mollie\SepaDirectDebit;

use PayHelper\Payum\Mollie\Constants;
use PayHelper\Payum\Mollie\Request\Api\CreateSepaOneOffPayment;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Model\BankAccountInterface;
use Payum\Core\Security\SensitiveValue;
use PH\Bundle\PayumBundle\Request\ObtainBankAccount;

class SepaOneOffObtainBankAccountAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if (!$model->validateNotEmpty(['sepaIban', 'sepaHolder'], false)) {
            try {
                $obtainBankAccount = new ObtainBankAccount($request->getToken());
                $obtainBankAccount->setModel($request->getModel());
                $this->gateway->execute($obtainBankAccount);

                /** @var BankAccountInterface $bankAccount */
                $bankAccount = $obtainBankAccount->obtain();

                $model['sepaIban'] = SensitiveValue::ensureSensitive($bankAccount->getIban());
                $model['sepaHolder'] = SensitiveValue::ensureSensitive($bankAccount->getHolder());

                $this->gateway->execute(new CreateSepaOneOffPayment($model));
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
            $request instanceof CreateSepaOneOffPayment &&
            $request->getModel() instanceof \ArrayAccess &&
            Constants::METHOD_DIRECTDEBIT_ONEOFF === $request->getModel()['method'] &&
            !isset($request->getModel()['sepaIban']) &&
            !isset($request->getModel()['sepaHolder'])
        ;
    }
}
