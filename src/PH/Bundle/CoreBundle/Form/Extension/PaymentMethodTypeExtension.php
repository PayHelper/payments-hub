<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Form\Extension;

use PH\Component\Core\Model\PaymentMethodInterface;
use Sylius\Bundle\PaymentBundle\Form\Type\PaymentMethodType;
use Sylius\Bundle\PayumBundle\Form\Type\GatewayConfigType;
use Sylius\Component\Core\Formatter\StringInflector;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class PaymentMethodTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $gatewayFactory = $options['data']->getGatewayConfig();

        $builder
            ->add('gatewayConfig', GatewayConfigType::class, [
                'label' => false,
                'data' => $gatewayFactory,
            ])
            ->add('supportsRecurring', CheckboxType::class)
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $paymentMethod = $event->getData();

                if (!$paymentMethod instanceof PaymentMethodInterface) {
                    return;
                }

                $gatewayConfig = $paymentMethod->getGatewayConfig();
                if (null === $gatewayConfig->getGatewayName()) {
                    $gatewayConfig->setGatewayName(StringInflector::nameToLowercaseCode($paymentMethod->getName()));
                }
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return PaymentMethodType::class;
    }
}
