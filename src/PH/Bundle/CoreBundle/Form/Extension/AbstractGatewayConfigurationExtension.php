<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

abstract class AbstractGatewayConfigurationExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minAmount', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                    new Range([
                        'min' => 0,
                        'groups' => 'ph',
                    ]),
                ],
            ])
            ->add('maxAmount', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'ph',
                    ]),
                ],
            ])
        ;
    }
}
