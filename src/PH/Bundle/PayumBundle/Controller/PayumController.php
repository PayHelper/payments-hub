<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Controller;

use FOS\RestBundle\View\View;
use Payum\Core\Payum;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Security\HttpRequestVerifierInterface;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;
use Sylius\Bundle\PayumBundle\Request\ResolveNextRoute;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ViewHandlerInterface;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class PayumController
{
    /**
     * @var Payum
     */
    private $payum;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var FormTypeRegistryInterface
     */
    private $gatewayConfigurationTypeRegistry;

    /**
     * @var MetadataInterface
     */
    private $orderMetadata;

    /**
     * @var RequestConfigurationFactoryInterface
     */
    private $requestConfigurationFactory;

    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param Payum                                $payum
     * @param OrderRepositoryInterface             $orderRepository
     * @param FormTypeRegistryInterface            $gatewayConfigurationTypeRegistry
     * @param MetadataInterface                    $orderMetadata
     * @param RequestConfigurationFactoryInterface $requestConfigurationFactory
     * @param ViewHandlerInterface                 $viewHandler
     * @param RouterInterface                      $router
     */
    public function __construct(
        Payum $payum,
        OrderRepositoryInterface $orderRepository,
        FormTypeRegistryInterface $gatewayConfigurationTypeRegistry,
        MetadataInterface $orderMetadata,
        RequestConfigurationFactoryInterface $requestConfigurationFactory,
        ViewHandlerInterface $viewHandler,
        RouterInterface $router
    ) {
        $this->payum = $payum;
        $this->orderRepository = $orderRepository;
        $this->gatewayConfigurationTypeRegistry = $gatewayConfigurationTypeRegistry;
        $this->orderMetadata = $orderMetadata;
        $this->requestConfigurationFactory = $requestConfigurationFactory;
        $this->viewHandler = $viewHandler;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param mixed   $tokenValue
     *
     * @return Response
     */
    public function prepareCaptureAction(Request $request, string $tokenValue)
    {
        $configuration = $this->requestConfigurationFactory->create($this->orderMetadata, $request);

        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneByTokenValue($tokenValue);

        if (null === $order) {
            throw new NotFoundHttpException(sprintf('Order with token "%s" does not exist.', $tokenValue));
        }

        $options = $configuration->getParameters()->get('redirect');

        /** @var PaymentInterface $payment */
        $payment = $order->getLastPayment(PaymentInterface::STATE_NEW);

        if (null === $payment) {
            return $this->viewHandler->handle($configuration, View::create([], 200));
        }

        $captureToken = $this->getTokenFactory()->createCaptureToken(
            $payment->getMethod()->getGatewayConfig()->getGatewayName(),
            $payment,
            isset($options['route']) ? $options['route'] : null,
            isset($options['parameters']) ? $options['parameters'] : []
        );

        $view = View::createRedirect($captureToken->getTargetUrl());

        return $this->viewHandler->handle($configuration, $view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function afterCaptureAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->orderMetadata, $request);

        $token = $this->getHttpRequestVerifier()->verify($request);

        $status = new GetStatus($token);
        $this->payum->getGateway($token->getGatewayName())->execute($status);
        $resolveNextRoute = new ResolveNextRoute($status->getFirstModel());
        $this->payum->getGateway($token->getGatewayName())->execute($resolveNextRoute);

        $this->getHttpRequestVerifier()->invalidate($token);

        return $this->viewHandler->handle(
            $configuration,
            View::createRouteRedirect($resolveNextRoute->getRouteName(), $resolveNextRoute->getRouteParameters())
        );
    }

    /**
     * @return GenericTokenFactoryInterface
     */
    private function getTokenFactory()
    {
        return $this->payum->getTokenFactory();
    }

    /**
     * @return HttpRequestVerifierInterface
     */
    private function getHttpRequestVerifier()
    {
        return $this->payum->getHttpRequestVerifier();
    }
}
