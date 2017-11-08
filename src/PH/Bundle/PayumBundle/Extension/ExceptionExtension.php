<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Extension;

use Payum\Core\Bridge\Symfony\Reply\HttpResponse;
use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Request\RenderTemplate;
use Symfony\Component\HttpFoundation\Response;

final class ExceptionExtension implements ExtensionInterface
{
    private $templateName;

    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * {@inheritdoc}
     */
    public function onPreExecute(Context $context)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function onExecute(Context $context)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function onPostExecute(Context $context)
    {
        if (null === ($exception = $context->getException())) {
            return;
        }

        $renderTemplate = new RenderTemplate($this->templateName);

        $context->getGateway()->execute($renderTemplate);

        throw new HttpResponse(new Response($renderTemplate->getResult(), 200));
    }
}
