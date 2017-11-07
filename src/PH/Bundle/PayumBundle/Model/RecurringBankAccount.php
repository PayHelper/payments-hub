<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Model;

use Payum\Core\Model\BankAccount;

class RecurringBankAccount extends BankAccount
{
    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
