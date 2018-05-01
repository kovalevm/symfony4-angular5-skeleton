<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\UserAccessToken;
use App\Service\Data\ApiAuthService;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @var ApiAuthService
     */
    protected $authService;

    /**
     * Constructor
     *
     * @param ApiAuthService $authService
     */
    public function __construct(ApiAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getTokenForApiKey($apiKey): UserAccessToken
    {
        return $this->authService->getToken($apiKey);
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
//        $username = 987654;

//        return $username;
    }

    public function loadUserByUsername($apiKey)
    {
        return $this->authService->getByToken($apiKey);

//        return new SecurityUser(
//            $username,
//            null,
//            // the roles for the user - you may choose to determine
//            // these dynamically somehow based on the user
//            array('ROLE_USER')
//        );
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function refreshToken(UserAccessToken $token)
    {
        $this->authService->refreshToken($token);
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}