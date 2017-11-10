<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Form\Type;

use PH\Bundle\SubscriptionBundle\Provider\StartDateProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StartDateChoiceType extends AbstractType
{
    /**
     * @var StartDateProviderInterface
     */
    private $startDateProvider;

    /**
     * StartDateChoiceType constructor.
     *
     * @param StartDateProviderInterface $startDateProvider
     */
    public function __construct(StartDateProviderInterface $startDateProvider)
    {
        $this->startDateProvider = $startDateProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => $this->startDateProvider->getStartDates(),
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
        return 'ph_start_date_choice';
    }
}
