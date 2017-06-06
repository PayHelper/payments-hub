<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Repository;

use Sylius\Bundle\OrderBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class OrderRepository extends BaseOrderRepository implements OrderRepositoryInterface
{

}
