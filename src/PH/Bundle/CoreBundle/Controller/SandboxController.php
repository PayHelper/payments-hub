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
        $form = $this->createForm(SubscriptionType::class);

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function thankYouAction(Request $request)
    {
        return $this->render('thankYou.html.twig', [
            'token' => $request->query->has('token') ? $request->query->has('token') : '',
        ]);
    }
}
