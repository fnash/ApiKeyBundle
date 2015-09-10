<?php

namespace Fnash\ApiKeyBundle\Security\Authentication\Token;

use Fnash\ApiKeyBundle\Entity\ApiClient;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleInterface;

class ApiKeyToken implements TokenInterface
{
    public function __construct($apiKey)
    {
        $this->apiClient = new ApiClient();
        $this->apiClient->setApiKey($apiKey);

        $this->setAuthenticated(true);
    }

    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var bool
     */
    private $authenticated;

    /**
     * @var array
     */
    private $attributes;

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object.
     *
     * @link http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->apiClient);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object.
     *
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     */
    public function unserialize($serialized)
    {
        $this->apiClient = unserialize($serialized);
    }

    /**
     * Returns a string representation of the Token.
     *
     * This is only to be used for debugging purposes.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->apiClient->getName();
    }

    /**
     * Returns the user roles.
     *
     * @return RoleInterface[] An array of RoleInterface instances.
     */
    public function getRoles()
    {
        return [new Role('ROLE_USER')];
    }

    /**
     * Returns the user credentials.
     *
     * @return mixed The user credentials
     */
    public function getCredentials()
    {
        return [];
    }

    /**
     * Returns a user representation.
     *
     * @return mixed Can be a UserInterface instance, an object implementing a __toString method,
     *               or the username as a regular string
     *
     * @see AbstractToken::setUser()
     */
    public function getUser()
    {
        return $this->apiClient;
    }

    /**
     * Sets a user.
     *
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->apiClient = $user;
    }

    /**
     * Returns the username.
     *
     * @return string
     */
    public function getUsername()
    {
        if ($this->apiClient instanceof ApiClient) {
            return $this->apiClient->getApiKey();
        }

        return (string) $this->apiClient;
    }

    /**
     * Returns whether the user is authenticated or not.
     *
     * @return bool true if the token has been authenticated, false otherwise
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * Sets the authenticated flag.
     *
     * @param bool $isAuthenticated The authenticated flag
     */
    public function setAuthenticated($isAuthenticated)
    {
        $this->authenticated = $isAuthenticated;
    }

    /**
     * Removes sensitive information from the token.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Returns the token attributes.
     *
     * @return array The token attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets the token attributes.
     *
     * @param array $attributes The token attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Returns true if the attribute exists.
     *
     * @param string $name The attribute name
     *
     * @return bool true if the attribute exists, false otherwise
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Returns an attribute value.
     *
     * @param string $name The attribute name
     *
     * @return mixed The attribute value
     *
     * @throws \InvalidArgumentException When attribute doesn't exist for this token
     */
    public function getAttribute($name)
    {
        if (!array_key_exists($name, $this->attributes)) {
            throw new \InvalidArgumentException(sprintf('This token has no "%s" attribute.', $name));
        }

        return $this->attributes[$name];
    }

    /**
     * Sets an attribute.
     *
     * @param string $name  The attribute name
     * @param mixed  $value The attribute value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
