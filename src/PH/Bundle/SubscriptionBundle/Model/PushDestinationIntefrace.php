<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface PushDestinationIntefrace extends ResourceInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     */
    public function setId($id);

    /**
     * @return bool
     */
    public function isActive();

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     */
    public function setUrl(string $url);
}
