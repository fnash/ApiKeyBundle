<?php

namespace Fnash\ApiKeyBundle\Security\User;

use Doctrine\Common\Persistence\ObjectManager;
use Fnash\ApiKeyBundle\Entity\ApiClient;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiClientUserProvider implements UserProviderInterface
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        return $this->loadClientByApiKey($username);
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof ApiClient) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $user;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Fnash\ApiKeyBundle\Entity\ApiClient';
    }

    /**
     * @param $apiKey
     *
     * @return ApiClient
     */
    public function loadClientByApiKey($apiKey)
    {
        $client = $this->entityManager->getRepository('FnashApiKeyBundle:ApiClient')
            ->findOneBy(['apiKey' => $apiKey]);

        if (!$client) {
            throw new UsernameNotFoundException();
        }

        return $client;
    }
}
