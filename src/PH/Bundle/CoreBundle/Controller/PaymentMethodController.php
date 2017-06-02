<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class PaymentMethodController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getPaymentGatewaysAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        return $this->viewHandler->handle($configuration, View::create($this->getParameter('sylius.gateway_factories')));
    }
}
