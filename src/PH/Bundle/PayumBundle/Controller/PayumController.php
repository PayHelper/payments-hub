<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Controller;

use FOS\RestBundle\View\View;
use Payum\Core\Payum;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Security\HttpRequestVerifierInterface;
use PH\Bundle\PayumBundle\Factory\ResolveNextUrlFactoryInterface;
use PH\Component\Core\Model\SubscriptionInterface;
use PH\Component\Core\Model\PaymentInterface;
use PH\Component\Core\Repository\SubscriptionRepositoryInterface;
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
     * @var SubscriptionRepositoryInterface
     */
    private $subscriptionRepository;

    /**
     * @var MetadataInterface
     */
    private $subscriptionMetadata;

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
     * @var ResolveNextUrlFactoryInterface
     */
    private $resolveNextUrlFactory;

    /**
     * @param Payum                                $payum
     * @param SubscriptionRepositoryInterface      $subscriptionRepository
     * @param MetadataInterface                    $subscriptionMetadata
     * @param RequestConfigurationFactoryInterface $requestConfigurationFactory
     * @param ViewHandlerInterface                 $viewHandler
     * @param RouterInterface                      $router
     * @param PaymentRepositoryInterface           $paymentRepository
     * @param ResolveNextUrlFactoryInterface       $resolveNextUrlFactory
     */
    public function __construct(
        Payum $payum,
        SubscriptionRepositoryInterface $subscriptionRepository,
        MetadataInterface $subscriptionMetadata,
        RequestConfigurationFactoryInterface $requestConfigurationFactory,
        ViewHandlerInterface $viewHandler,
        RouterInterface $router,
        PaymentRepositoryInterface $paymentRepository,
        ResolveNextUrlFactoryInterface $resolveNextUrlFactory
    ) {
        $this->payum = $payum;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionMetadata = $subscriptionMetadata;
        $this->requestConfigurationFactory = $requestConfigurationFactory;
        $this->viewHandler = $viewHandler;
        $this->router = $router;
        $this->paymentRepository = $paymentRepository;
        $this->resolveNextUrlFactory = $resolveNextUrlFactory;
    }

    /**
     * @param Request $request
     * @param mixed   $token
     *
     * @return Response
     */
    public function prepareCaptureAction(Request $request, string $token): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->subscriptionMetadata, $request);

        /** @var SubscriptionInterface $subscription */
        $subscription = $this->subscriptionRepository->findOneByTokenValue($token);

        if (null === $subscription) {
            throw new NotFoundHttpException(sprintf('Subscription with token "%s" does not exist.', $token));
        }

        $options = $configuration->getParameters()->get('redirect');

        /** @var PaymentInterface $payment */
        $payment = $subscription->getLastPayment(PaymentInterface::STATE_NEW);

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
     *
     * @throws \InvalidArgumentException
     */
    public function afterCaptureAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->subscriptionMetadata, $request);
        $token = $this->getHttpRequestVerifier()->verify($request);
        $status = new GetStatus($token);

        $this->payum->getGateway($token->getGatewayName())->execute($status);

        if (!$request->query->has('redirect')) {
            $resolveNextUrl = $this->resolveNextUrlFactory->createNewWithModel($status->getFirstModel());
            $this->payum->getGateway($token->getGatewayName())->execute($resolveNextUrl);
            $redirect = $resolveNextUrl->getUrl();
        } else {
            $redirect = $request->query->get('redirect');
        }

        $this->getHttpRequestVerifier()->invalidate($token);

        $view = View::createRedirect($redirect);

        return $this->viewHandler->handle($configuration, $view);
    }

    /**
     * @param Request $request
     * @param string  $subscriptionId
     * @param string  $id
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function cancelAction(Request $request, string $subscriptionId, string $id): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->subscriptionMetadata, $request);

        /** @var PaymentInterface|null $payment */
        $payment = $this->paymentRepository->findOneBySubscriptionId($id, $subscriptionId);

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
     *
     * @throws \InvalidArgumentException
     */
    public function afterCancelAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->subscriptionMetadata, $request);
        $token = $this->getHttpRequestVerifier()->verify($request);
        $status = new GetStatus($token);

        $this->payum->getGateway($token->getGatewayName())->execute($status);
        $this->getHttpRequestVerifier()->invalidate($token);

        $view = View::create([], 204);

        return $this->viewHandler->handle($configuration, $view);
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
