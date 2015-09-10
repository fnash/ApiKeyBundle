<?php

namespace Fnash\ApiKeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnash\ApiKeyBundle\Util\ApiKeyGenerator;

/**
 * @ORM\Table(name="pushinfo.api_client")
 * @ORM\Entity
 */
class ApiClient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=255)
     */
    protected $apiKey;

    public function __construct()
    {
        $this->setApiKey(ApiKeyGenerator::generate());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $apiKey
     *
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function __toString()
    {
        return $this->apiKey;
    }
}
