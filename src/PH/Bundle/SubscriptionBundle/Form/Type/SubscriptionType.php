<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Form\Type;

use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('currencyCode', CurrencyType::class)
            ->add('interval', ChoiceType::class, [
                'choices' => [
                    'Monthly' => SubscriptionInterface::INTERVAL_MONTH,
                    'Quarterly' => SubscriptionInterface::INTERVAL_QUARTERLY,
                    'Yearly' => SubscriptionInterface::INTERVAL_YEAR,
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Non-recurring' => SubscriptionInterface::TYPE_NON_RECURRING,
                    'Recurring' => SubscriptionInterface::TYPE_RECURRING,
                ],
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'choice',
                'days' => [date('d'), 1, 15],
                'years' => [date('Y')],
                'months' => [date('m'), date('m') + 1, date('m') + 2],
                'data' => new \DateTime(),
            ])
            ->add('submit', SubmitType::class)
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
