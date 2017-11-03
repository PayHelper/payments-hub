<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Controller;

use FOS\RestBundle\View\View;
use PH\Bundle\CoreBundle\SubscriptionEvents;
use PH\Bundle\CoreBundle\Facade\SubscriptionFacadeInterface;
use PH\Component\Subscription\Model\SubscriptionInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SubscriptionController extends ResourceController
{
    public function addAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, SubscriptionEvents::CREATE);

        /** @var SubscriptionInterface $subscription */
        $subscription = $this->newResourceFactory->create($configuration, $this->factory);

        $form = $this->getFormFactory()->createNamed(
            '',
            $configuration->getFormType(),
            $subscription,
            array_merge($configuration->getFormOptions(), ['csrf_protection' => false])
        );

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            /** @var SubscriptionInterface $subscription */
            $subscription = $form->getData();

            $event = $this->eventDispatcher->dispatchPreEvent(SubscriptionEvents::CREATE, $configuration, $subscription);

            if ($event->isStopped() && !$configuration->isHtmlRequest()) {
                throw new HttpException($event->getErrorCode(), $event->getMessage());
            }

            $subscription = $this->getSubscriptionFacade()->prepareSubscription($subscription);
            if ($configuration->hasStateMachine()) {
                $this->stateMachine->apply($configuration, $subscription);
            }
            $this->repository->add($subscription);
            $this->eventDispatcher->dispatchPostEvent(SubscriptionEvents::CREATE, $configuration, $subscription);

            return $this->viewHandler->handle($configuration, View::create($subscription, Response::HTTP_CREATED));
        }

        return $this->viewHandler->handle($configuration, View::create($form, Response::HTTP_BAD_REQUEST));
    }

    /**
     * @return FormFactoryInterface
     */
    protected function getFormFactory(): FormFactoryInterface
    {
        return $this->get('form.factory');
    }

    /**
     * @return SubscriptionFacadeInterface
     */
    protected function getSubscriptionFacade(): SubscriptionFacadeInterface
    {
        return $this->get('ph.facade.subscription');
    }
}
