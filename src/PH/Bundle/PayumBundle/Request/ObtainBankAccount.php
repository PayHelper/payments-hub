<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Request;

use Payum\Core\Exception\LogicException;
use Payum\Core\Model\BankAccountInterface;
use Payum\Core\Request\Generic;

class ObtainBankAccount extends Generic
{
    /**
     * @var BankAccountInterface
     */
    protected $bankAccount;

    /**
     * @param BankAccountInterface $bankAccount
     */
    public function set(BankAccountInterface $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * @return BankAccountInterface
     */
    public function obtain(): BankAccountInterface
    {
        if (false == $this->bankAccount) {
            throw new LogicException('Bank Account could not be obtained. It has to be set before obtain.');
        }

        return $this->bankAccount;
    }
}
