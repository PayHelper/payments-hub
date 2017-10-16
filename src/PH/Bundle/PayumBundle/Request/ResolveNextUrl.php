<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Request;

use Payum\Core\Request\Generic;

class ResolveNextUrl extends Generic implements ResolveNextUrlInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $urlQueryParams = [];

    public function getUrl(): ?string
    {
        if (empty($this->getUrlQueryParams())) {
            return $this->url;
        }

        return rtrim($this->url, '/').'?'.http_build_query($this->getUrlQueryParams());
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrlQueryParams(): array
    {
        return $this->urlQueryParams;
    }

    public function setUrlQueryParams(array $urlQueryParams): void
    {
        $this->urlQueryParams = $urlQueryParams;
    }
}
