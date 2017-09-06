<?php

namespace PH\Bundle\PayumBundle\Request;

use LogicException;
use Payum\Core\Model\BankAccountInterface;
use Payum\Core\Request\Generic;

class ObtainSepaBankAccount extends Generic
{
    protected $bankAccount;

    /**
     * @return mixed
     *
     * @throws \LogicException
     */
    public function getBankAccount()
    {
        //        if (null === $this->bankAccount) {
        //            throw new LogicException('Bank account could not be obtained. It has to be set before obtain.');
        //        }

        return $this->bankAccount;
    }

    /**
     * @param BankAccountInterface $bankAccount
     */
    public function setBankAccount(BankAccountInterface $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }
}
