<?php

namespace Fnash\ApiKeyBundle\Security\Authentication\Provider;

use Fnash\ApiKeyBundle\Security\Authentication\Token\ApiKeyToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ApiClientAuthenticationProvider implements AuthenticationProviderInterface
{
    private $apiClientUserProvider;

    public function __construct(UserProviderInterface $apiClientUserProvider)
    {
        $this->apiClientUserProvider = $apiClientUserProvider;
    }

    public function authenticate(TokenInterface $token)
    {
        $apiClient = $this->apiClientUserProvider->loadUserByUsername($token->getUsername());

        if ($apiClient) {
            $token->setUser($apiClient);

            return $token;
        }

        throw new AuthenticationException('The API Key authentication failed.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof ApiKeyToken;
    }
}
