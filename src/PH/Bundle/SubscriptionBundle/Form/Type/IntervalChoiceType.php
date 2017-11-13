<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Form\Type;

use PH\Bundle\SubscriptionBundle\Provider\SubscriptionIntervalsProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class IntervalChoiceType extends AbstractType
{
    /**
     * @var SubscriptionIntervalsProviderInterface
     */
    private $subscriptionIntervalsProvider;

    /**
     * IntervalChoiceType constructor.
     *
     * @param SubscriptionIntervalsProviderInterface $subscriptionIntervalsProvider
     */
    public function __construct(SubscriptionIntervalsProviderInterface $subscriptionIntervalsProvider)
    {
        $this->subscriptionIntervalsProvider = $subscriptionIntervalsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => $this->subscriptionIntervalsProvider->getIntervals(),
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'ph_interval_choice';
    }
}
