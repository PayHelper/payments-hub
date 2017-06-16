<?php

declare(strict_types=1);

namespace PH\Component\Core\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PH\Bundle\SubscriptionBundle\Model\Order as BaseOrder;
use PH\Component\Core\OrderCheckoutStates;
use PH\Component\Core\OrderPaymentStates;

class Order extends BaseOrder implements OrderInterface
{
    /**
     * @var Collection|PaymentInterface[]
     */
    protected $payments;

    /**
     * @var string
     */
    protected $checkoutState = OrderCheckoutStates::STATE_NEW;

    /**
     * @var string
     */
    protected $paymentState = OrderPaymentStates::STATE_NEW;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->payments = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * {@inheritdoc}
     */
    public function setPayments(Collection $payments): void
    {
        $this->payments = $payments;
    }

    /**
     * {@inheritdoc}
     */
    public function getCheckoutState(): string
    {
        return $this->checkoutState;
    }

    /**
     * {@inheritdoc}
     */
    public function setCheckoutState(string $checkoutState): void
    {
        $this->checkoutState = $checkoutState;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentState(): string
    {
        return $this->paymentState;
    }

    /**
     * {@inheritdoc}
     */
    public function setPaymentState(string $paymentState): void
    {
        $this->paymentState = $paymentState;
    }
}
