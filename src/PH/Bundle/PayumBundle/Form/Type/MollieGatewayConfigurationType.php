<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class MollieGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apiKey', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
            ->add('method', ChoiceType::class, [
                'choices' => [
                    'SEPA Direct Debit' => 'directdebit',
                    'Credit Card' => 'creditcard',
                    'One-off SEPA Direct Debit' => 'directdebit_oneoff',
                ],
            ])
        ;
    }
}
