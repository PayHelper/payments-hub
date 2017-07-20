<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');
    }

    public function thankYouAction(Request $request)
    {
        return $this->render('index.html.twig', [
            'token' => $request->query->has('token') ? $request->query->has('token') : '',
        ]);
    }
}
