<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Request;

interface ResolveNextUrlInterface
{
    public function getUrl(): ?string;

    public function setUrl(string $url): void;

    public function getUrlQueryParams(): array;

    public function setUrlQueryParams(array $urlQueryParams): void;
}
