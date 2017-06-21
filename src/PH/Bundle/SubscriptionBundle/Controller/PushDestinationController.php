<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Controller;

use PH\Bundle\SubscriptionBundle\Form\Type\PushDestinationType;
use PH\Bundle\SubscriptionBundle\Model\PushDestinationIntefrace;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PushDestinationController extends Controller
{
    /**
     * @Route("/api/push/destinations", name="api_push_destinations")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        /** @var RepositoryInterface $order */
        // $pushDestinationRepository = $this->container->get('ph.repository.push_destination');
        /** @var FactoryInterface $pushDestinationFactory */
        $pushDestinationFactory = $this->container->get('ph.factory.push_destination');
        /** @var PushDestinationIntefrace $pushDestination */
        $pushDestination = $pushDestinationFactory->createNew();

        $form = $this->createForm(PushDestinationType::class, $pushDestination, [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($pushDestination);
            $em->flush();

            $data = $this->container->get('serializer')->serialize($pushDestination, 'json');

            return new Response($data);
        }

        return new JsonResponse(['status' => 'NOK']);
    }
}
