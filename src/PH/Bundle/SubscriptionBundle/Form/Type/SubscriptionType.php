<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Form\Type;

use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;

final class SubscriptionType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', MoneyType::class, [
                'currency' => false,
            ])
            ->add('currencyCode', CurrencyType::class)
            ->add('interval', IntervalChoiceType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Non-recurring' => SubscriptionInterface::TYPE_NON_RECURRING,
                    'Recurring' => SubscriptionInterface::TYPE_RECURRING,
                ],
            ])
            ->add('startDate', StartDateChoiceType::class)
        ;

        $builder->get('startDate')
            ->addModelTransformer(new CallbackTransformer(
                function ($value) {
                    return $value;
                },
                function ($value) {
                    if (is_string($value)) {
                        return new \DateTime($value);
                    }
                }
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ph_subscription';
    }
}
