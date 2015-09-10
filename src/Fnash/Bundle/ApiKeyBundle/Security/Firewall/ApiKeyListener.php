<?php

namespace Fnash\ApiKeyBundle\Security\Firewall;

use Fnash\ApiKeyBundle\Extractor\KeyExtractorInterface;
use Fnash\ApiKeyBundle\Security\Authentication\Token\ApiKeyToken;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class ApiKeyListener implements ListenerInterface
{
    /**
     * @var KeyExtractorInterface
     */
    protected $keyExtractor;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, KeyExtractorInterface $keyExtractor)
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->keyExtractor = $keyExtractor;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$this->keyExtractor->hasKey($request)) {
            $response = new Response();
            $response->setStatusCode(401);
            $event->setResponse($response);

            return;
        }

        $apiKey = $this->keyExtractor->extractKey($request);

        $token = new ApiKeyToken($apiKey);

        try {
            $authToken = $this->authenticationManager->authenticate($token);

            $this->securityContext->setToken($authToken);
        } catch (AuthenticationException $failed) {
            // ... you might log something here

            // To deny the authentication clear the token. This will redirect to the login page.
            // $this->securityContext->setToken(null);
            // return;

            // Deny authentication with a '403 Forbidden' HTTP response
            $response = new Response();
            $response->setStatusCode(403);
            $event->setResponse($response);
        }
    }
}
