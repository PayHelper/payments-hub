<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Controller;

use PH\Bundle\SubscriptionBundle\Event\OrderEvent;
use PH\Bundle\SubscriptionBundle\OrderEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PH\Bundle\SubscriptionBundle\Form\Type\SubscriptionType;
use PH\Bundle\SubscriptionBundle\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    /**
     * @Route("/api/v1/subscription", name="api_subscription")
     * @Method("POST")
     */
    public function createAction(Request $request)
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
            $order = $this->container->get('ph.service.order')->prepareOrder($order, $data);
            $this->container->get('sylius.repository.order')->add($order);

            $this->container->get('event_dispatcher')->dispatch(OrderEvents::ORDER_UPDATE, new OrderEvent($order));

            return new JsonResponse(['status' => 'OK']);
        }

        return new JsonResponse(['status' => 'NOK']);
    }
}
