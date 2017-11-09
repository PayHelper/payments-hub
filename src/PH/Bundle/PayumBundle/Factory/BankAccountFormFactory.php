<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Factory;

use PH\Bundle\PayumBundle\Form\Type\BankAccountType;
use PH\Bundle\PayumBundle\Form\Type\RecurringBankAccountType;
use PH\Component\Core\Model\SubscriptionInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

final class BankAccountFormFactory implements BankAccountFormFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * BankAccountFormFactory constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function createBankAccountForm(string $type): FormInterface
    {
        switch ($type) {
            case SubscriptionInterface::TYPE_RECURRING:
                return $this->formFactory->create(RecurringBankAccountType::class);
            case SubscriptionInterface::TYPE_NON_RECURRING:
                return $this->formFactory->create(BankAccountType::class);
            default:
                throw new \InvalidArgumentException(sprintf('%s is not a valid subscription type', $type));
        }
    }
}
