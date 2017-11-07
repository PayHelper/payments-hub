<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Form\Type;

use PH\Bundle\PayumBundle\Model\RecurringBankAccount;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecurringBankAccountType extends BankAccountType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('bic', TextType::class, [
                'label' => 'form.bank_account.bic',
            ])
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'form.bank_account.email.match',
                'first_options' => ['label' => 'form.bank_account.email.label'],
                'second_options' => ['label' => 'form.bank_account.email.repeat_label'],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => RecurringBankAccount::class,
                'validation_groups' => ['ph_recurring_bank_account'],
                'label' => false,
                'translation_domain' => 'PayumBundle',
            ])
        ;
    }
}
