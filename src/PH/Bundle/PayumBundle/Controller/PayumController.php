<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Controller;

use FOS\RestBundle\View\View;
use Payum\Core\Payum;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Security\HttpRequestVerifierInterface;
use PH\Component\Core\Model\OrderInterface;
use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Repository\OrderRepositoryInterface;
use PH\Component\Core\Repository\PaymentRepositoryInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ViewHandlerInterface;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * @var PaymentRepositoryInterface
     */
    private $paymentRepository;

    /**
     * @param Payum                                $payum
     * @param OrderRepositoryInterface             $orderRepository
     * @param MetadataInterface                    $orderMetadata
     * @param RequestConfigurationFactoryInterface $requestConfigurationFactory
     * @param ViewHandlerInterface                 $viewHandler
     * @param RouterInterface                      $router
     * @param PaymentRepositoryInterface           $paymentRepository
     */
    public function __construct(
        Payum $payum,
        OrderRepositoryInterface $orderRepository,
        MetadataInterface $orderMetadata,
        RequestConfigurationFactoryInterface $requestConfigurationFactory,
        ViewHandlerInterface $viewHandler,
        RouterInterface $router,
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->payum = $payum;
        $this->orderRepository = $orderRepository;
        $this->orderMetadata = $orderMetadata;
        $this->requestConfigurationFactory = $requestConfigurationFactory;
        $this->viewHandler = $viewHandler;
        $this->router = $router;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param Request $request
     * @param mixed   $token
     *
     * @return Response
     */
    public function prepareCaptureAction(Request $request, string $token): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->orderMetadata, $request);

        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneByTokenValue($token);

        if (null === $order) {
            throw new NotFoundHttpException(sprintf('Order with token "%s" does not exist.', $token));
        }

        $options = $configuration->getParameters()->get('redirect');

        /** @var PaymentInterface $payment */
        $payment = $order->getLastPayment(PaymentInterface::STATE_NEW);

        if (null === $payment) {
            return $this->viewHandler->handle($configuration, View::create([], 404));
        }

        $captureToken = $this->getTokenFactory()->createCaptureToken(
            $payment->getMethod()->getGatewayConfig()->getGatewayName(),
            $payment,
            $options['route'] ?? null,
            $options['parameters'] ?? []
        );

        $view = View::createRedirect($captureToken->getTargetUrl());

        return $this->viewHandler->handle($configuration, $view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function afterCaptureAction(Request $request): Response
    {
        $configuration = $this->afterAction($request);

        $view = View::createRedirect($request->query->get('thankyou'));

        return $this->viewHandler->handle($configuration, $view);
    }

    /**
     * @param Request $request
     * @param string  $orderId
     * @param string  $id
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function cancelAction(Request $request, string $orderId, string $id): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->orderMetadata, $request);

        /** @var PaymentInterface|null $order */
        $payment = $this->paymentRepository->findOneByOrderId($id, $orderId);

        if (null === $payment) {
            throw new NotFoundHttpException(sprintf('Payment with id "%s" does not exist.', $id));
        }

        if (PaymentInterface::STATE_CANCELLED === $payment->getState()) {
            throw new HttpException(409, 'The payment has been already cancelled!');
        }

        $options = $configuration->getParameters()->get('redirect');

        $cancelToken = $this->getTokenFactory()->createCancelToken(
            $payment->getMethod()->getGatewayConfig()->getGatewayName(),
            $payment,
            $options['route'] ?? null,
            $options['parameters'] ?? []
        );

        $view = View::createRedirect($cancelToken->getTargetUrl());

        return $this->viewHandler->handle($configuration, $view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function afterCancelAction(Request $request): Response
    {
        $configuration = $this->afterAction($request);

        $view = View::create([], 204);

        return $this->viewHandler->handle($configuration, $view);
    }

    private function afterAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->orderMetadata, $request);

        $token = $this->getHttpRequestVerifier()->verify($request);

        $status = new GetStatus($token);

        $this->payum->getGateway($token->getGatewayName())->execute($status);
        $this->getHttpRequestVerifier()->invalidate($token);

        return $configuration;
    }

    /**
     * @return GenericTokenFactoryInterface
     */
    private function getTokenFactory(): GenericTokenFactoryInterface
    {
        return $this->payum->getTokenFactory();
    }

    /**
     * @return HttpRequestVerifierInterface
     */
    private function getHttpRequestVerifier(): HttpRequestVerifierInterface
    {
        return $this->payum->getHttpRequestVerifier();
    }
}
