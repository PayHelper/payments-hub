<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Mbe4GatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
            ->add('password', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
            ->add('clientId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
            ->add('serviceId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
            ->add('contentclass', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
        ;
    }
}
