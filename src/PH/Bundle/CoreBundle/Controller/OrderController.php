<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Controller;

use FOS\RestBundle\View\View;
use PH\Bundle\CoreBundle\OrderEvents;
use PH\Bundle\CoreBundle\Facade\OrderFacadeInterface;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrderController extends ResourceController
{
    public function addAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, OrderEvents::CREATE);

        /** @var OrderInterface $order */
        $order = $this->newResourceFactory->create($configuration, $this->factory);
        $form = $this->getFormFactory()->createNamed(
            '',
            $configuration->getFormType(),
            $this->createSubscription(),
            array_merge($configuration->getFormOptions(), ['csrf_protection' => false])
        );

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            /** @var SubscriptionInterface $subscription */
            $subscription = $form->getData();
            $event = $this->eventDispatcher->dispatchPreEvent(OrderEvents::CREATE, $configuration, $order);

            if ($event->isStopped() && !$configuration->isHtmlRequest()) {
                throw new HttpException($event->getErrorCode(), $event->getMessage());
            }

            $this->getOrderService()->prepareOrder($order, $subscription);
            $this->repository->add($order);
            $this->eventDispatcher->dispatchPostEvent(OrderEvents::CREATE, $configuration, $order);

            return $this->viewHandler->handle($configuration, View::create($order, Response::HTTP_CREATED));
        }

        return $this->viewHandler->handle($configuration, View::create($form, Response::HTTP_BAD_REQUEST));
    }

    /**
     * @return FormFactoryInterface
     */
    protected function getFormFactory()
    {
        return $this->get('form.factory');
    }

    /**
     * @return SubscriptionInterface
     */
    protected function createSubscription()
    {
        return $this->get('ph.factory.subscription')->createNew();
    }

    /**
     * @return OrderFacadeInterface
     */
    protected function getOrderService()
    {
        return $this->get('ph.facade.order');
    }
}
