<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Form\Extension;

use PH\Bundle\CoreBundle\Provider\PaymentMethodsProviderInterface;
use PH\Bundle\SubscriptionBundle\Form\Type\SubscriptionType;
use Sylius\Bundle\PaymentBundle\Form\Type\PaymentMethodChoiceType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

final class SubscriptionTypeExtension extends AbstractTypeExtension
{
    private $paymentMethodsProvider;

    public function __construct(PaymentMethodsProviderInterface $paymentMethodsProvider)
    {
        $this->paymentMethodsProvider = $paymentMethodsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formModifier = function (FormInterface $form, string $type = null) {
            $methods = null === $type ? [] : $this->paymentMethodsProvider->getSupportedMethods($type);

            $form->add('method', PaymentMethodChoiceType::class, array(
                'choices' => $methods,
                'expanded' => true,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getType());
            }
        );

        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $type = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $type);
            }
        );

        $builder
            ->add('submit', SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return SubscriptionType::class;
    }
}
