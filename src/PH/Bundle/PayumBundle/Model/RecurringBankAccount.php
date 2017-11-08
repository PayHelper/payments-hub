<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Model;

use Payum\Core\Model\BankAccount;

class RecurringBankAccount extends BankAccount implements EmailAwareInterface
{
    /**
     * @var null|string
     */
    private $email;

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
