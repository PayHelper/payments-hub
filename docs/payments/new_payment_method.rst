How to support a new payment gateway?
=====================================

Payments Hub is using Payum library to handle the payments.

There might be a reason to introduce a new payment gateway to support payments using different channels (e.g. phone bill, credit card etc.).
Payum supports currently a lot of open-source gateways which list can be found here.

For a purpose of this guide, the `Mbe4`_ Payum extension has been used.

1. Register gateway as a service
--------------------------------

First, the gateway needs to be registered as a service inside your `services.yml` file so put the following definition
into that file:

.. code-block:: yaml

    ph.payum.mbe4.factory:
        class: Payum\Core\Bridge\Symfony\Builder\GatewayFactoryBuilder
        arguments: [PayHelper\Payum\Mbe4\Mbe4GatewayFactory]
        tags:
            - { name: payum.gateway_factory_builder, factory: mbe4 }

Payments Hub will automatically register a new gateway in the registry/container so it can be available in the system.

2. A new gateway configuration form type
----------------------------------------

A form type will need to be created in order to be able to expose the gateway-specific configuration to the API and be able
to save gateway's configuration in the database.

The configuration of every gateway should be documented in the Payum extension's documentation that is going to be used.

.. code-block:: php

    <?php

    declare(strict_types=1);

    namespace PH\Bundle\PayumBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Validator\Constraints\NotBlank;
    use Symfony\Component\Validator\Constraints\Range;

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

Register a new form type as a service in ``services.yml`` file:

.. code-block:: yaml

    ph.form.type.gateway_configuration.mbe4:
        class: PH\Bundle\PayumBundle\Form\Type\Mbe4GatewayConfigurationType
        tags:
            - { name: sylius.gateway_configuration_type, type: 'mbe4', label: 'Mbe4' }
            - { name: form.type }


Note that the ``sylius.gateway_configuration_type`` tag has been added, which will add the configuration defined in
the form type to the Payum gateway’s configuration automatically so there is no need to define the configuration
of the Payum gateway in the ``config.yml`` file.

That's it! A support for a new payment gateway is now added to the system and the Mbe4 gateway can be managed using API.

.. _`Mbe4`: https://www.mbe4.de/
