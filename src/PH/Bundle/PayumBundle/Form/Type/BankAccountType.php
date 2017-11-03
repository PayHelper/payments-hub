<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Form\Type;

use Payum\Core\Model\BankAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BankAccountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('holder', TextType::class, [
                'label' => 'form.bank_account.holder',
            ])
            ->add('iban', TextType::class, [
                'label' => 'form.bank_account.iban',
            ])
            ->add('bic', TextType::class, [
                'label' => 'form.bank_account.bic',
                'required' => false,
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
                'data_class' => BankAccount::class,
                'validation_groups' => ['ph'],
                'label' => false,
                'translation_domain' => 'PayumBundle',
            ])
        ;
    }
}
