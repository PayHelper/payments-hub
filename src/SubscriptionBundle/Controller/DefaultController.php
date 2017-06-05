<?php

namespace SubscriptionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SubscriptionBundle\Form\Type\SubscriptionType;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/api/subscription", name="api_subscription")
     * @Method("POST")
     */
    public function indexAction(Request $request)
    {
        /** @var FactoryInterface $order */
        $orderFactory = $this->container->get('sylius.factory.order');
        /** @var OrderInterface $order */
        $order = $orderFactory->createNew();

        $form = $this->createForm(SubscriptionType::class, [], [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            /** @var OrderItemInterface $orderItem */
            $orderItem = $this->container->get('sylius.factory.order_item')->createNew();
            $this->container->get('sylius.order_item_quantity_modifier')->modify($orderItem, 1);
            $orderItem->setUnitPrice((int) $data['amount']);
            $order->addItem($orderItem);
            $order->recalculateItemsTotal();
            $order->completeCheckout();
            $orderRepository = $this->container->get('sylius.repository.order');
            $orderRepository->add($order);

            return new JsonResponse(['status' => 'OK']);
        }

        return new JsonResponse(['status' => 'NOK']);
    }
}
