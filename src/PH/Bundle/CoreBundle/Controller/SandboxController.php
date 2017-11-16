<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Controller;

use PH\Bundle\SubscriptionBundle\Form\Type\SubscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {
        $subscriptionFactory = $this->get('ph.factory.subscription');

        $form = $this->createForm(SubscriptionType::class, $subscriptionFactory->createNew());
        $form->handleRequest($request);

        return $this->render('@PHCore/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function thankYouAction(Request $request)
    {
        return $this->render('@PHCore/thankYou.html.twig', [
            'token' => $request->query->has('token') ? $request->query->has('token') : '',
        ]);
    }

    public function cancelAction(Request $request)
    {
        return $this->render('@PHCore/cancel.html.twig', [
            'token' => $request->query->has('token') ? $request->query->has('token') : '',
        ]);
    }
}
