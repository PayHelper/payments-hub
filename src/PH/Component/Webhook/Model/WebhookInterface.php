<?php

declare(strict_types=1);

namespace PH\Component\Webhook\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface WebhookInterface extends ResourceInterface, ToggleableInterface
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     */
    public function setUrl(string $url);
}
