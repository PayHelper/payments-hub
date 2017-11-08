<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Model;

interface EmailAwareInterface
{
    /**
     * @return null|string
     */
    public function getEmail(): ?string;

    /**
     * @param null|string $email
     */
    public function setEmail(?string $email): void;
}
