<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Form\Type;

use PH\Bundle\SubscriptionBundle\Helper\DateTimeHelperInterface;
use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

final class SubscriptionType extends AbstractResourceType
{
    /**
     * @var DateTimeHelperInterface
     */
    private $dateTimeHelper;

    /**
     * SubscriptionType constructor.
     *
     * @param string                  $dataClass
     * @param array                   $validationGroups
     * @param DateTimeHelperInterface $dateTimeHelper
     */
    public function __construct($dataClass, $validationGroups = [], DateTimeHelperInterface $dateTimeHelper)
    {
        parent::__construct($dataClass, $validationGroups);

        $this->dateTimeHelper = $dateTimeHelper;
    }

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
                'days' => [$this->dateTimeHelper->getCurrentDay(), 1, 15],
                'years' => [$this->dateTimeHelper->getCurrentYear()],
                'months' => [
                    $this->dateTimeHelper->getCurrentMonth(),
                    $this->dateTimeHelper->getCurrentMonth(1),
                    $this->dateTimeHelper->getCurrentMonth(2),
                ],
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
