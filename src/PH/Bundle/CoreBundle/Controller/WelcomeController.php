<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');
    }
}
