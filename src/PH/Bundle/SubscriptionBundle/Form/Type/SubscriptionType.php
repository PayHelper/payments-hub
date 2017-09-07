<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Form\Type;

use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;

final class SubscriptionType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', IntegerType::class)
            ->add('currencyCode')
            ->add('interval', ChoiceType::class, [
                'choices' => [
                    'Monthly' => SubscriptionInterface::INTERVAL_MONTH,
                    'Quarterly' => SubscriptionInterface::INTERVAL_QUARTERLY,
                    'Yearly' => SubscriptionInterface::INTERVAL_YEAR,
                ],
            ])
            ->add('code')
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Non-recurring' => SubscriptionInterface::TYPE_ONETIME,
                    'Recurring' => SubscriptionInterface::TYPE_RECURRING,
                ],
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'choice',
                'days' => [1, 15],
                'years' => [date('Y')],
                'months' => [date('m') + 1, date('m') + 2],
                'data' => new \DateTime(),
            ])
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
