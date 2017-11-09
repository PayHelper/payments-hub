<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Factory;

use Symfony\Component\Form\FormInterface;

interface BankAccountFormFactoryInterface
{
    /**
     * @param string $type
     *
     * @return FormInterface
     *
     * @throws \InvalidArgumentException
     */
    public function createBankAccountForm(string $type): FormInterface;
}
