<?php

namespace AppBundle\Repository;

use Sylius\Component\Order\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
interface OrderRepositoryInterface extends BaseOrderRepositoryInterface
{
    public function count();
}
