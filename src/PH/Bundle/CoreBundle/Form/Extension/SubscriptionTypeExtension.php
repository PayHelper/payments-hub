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
    /**
     * @var PaymentMethodsProviderInterface
     */
    private $paymentMethodsProvider;

    /**
     * SubscriptionTypeExtension constructor.
     *
     * @param PaymentMethodsProviderInterface $paymentMethodsProvider
     */
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

            $form->add('method', PaymentMethodChoiceType::class, [
                'choices' => $methods,
                'expanded' => true,
            ]);
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
                $type = $event->getForm()->getData();
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
