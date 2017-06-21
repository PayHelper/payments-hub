<?php

declare(strict_types=1);

namespace PH\Bundle\SubscriptionBundle\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;

class PushDestination implements PushDestinationIntefrace
{
    use TimestampableTrait;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var bool
     */
    protected $isActive;

    /**
     * @var string
     */
    protected $url;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }
}
