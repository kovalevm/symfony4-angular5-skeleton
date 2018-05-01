<?php

namespace App\Service\Data;

use App\Entity\User;
use App\Entity\UserAccessToken;
use Firebase\JWT\JWT;

/**
 * Service to manage API authorization data
 */
class ApiAuthService extends BaseService
{
    const TOKEN_DURATION = "30 minutes";

    public function generate(User $user, string $jwtKey): string
    {
        $now = new \DateTime();

        $token = array(
            'iat'   => $now->getTimestamp(),
            'uid'   => $user->getId(),
            'uname' => $user->getEmail(),
        );

        $jwt = JWT::encode($token, $jwtKey);

        // remove expired old
//        foreach ($user->getTokens() as $i => $token) {
//            if ($token->getExpiredAt()->getTimestamp() > $now->getTimestamp()) {
//                $user->getTokens()->remove($i);
//            }
//        }

        $token = new UserAccessToken();
        $token
            ->setAccessToken($jwt)
            ->setUser($user)
            ->setCreatedAt(clone $now)
            ->setExpiredAt($now->add(\DateInterval::createFromDateString(self::TOKEN_DURATION)));

        $user->getTokens()->add($token);

        $this->em->persist($user);
        $this->em->flush();

        return $jwt;
    }

    public function getByToken(string $jwt): User
    {
        /** @var UserAccessToken $token */
        $token = $this->em
            ->getRepository(UserAccessToken::class)
            ->findOneBy(array('accessToken' => $jwt));

        if ($token !== null) {
            return $token->getUser();
        }

        return null;
    }

    public function getToken(string $jwt): UserAccessToken
    {
        return $this->em
            ->getRepository(UserAccessToken::class)
            ->findOneBy(array('accessToken' => $jwt));
    }

    public function refreshToken(UserAccessToken $token)
    {
        $now = new \DateTime();
        $token->setExpiredAt($now->add(\DateInterval::createFromDateString(self::TOKEN_DURATION)));
        $this->em->flush();
    }
}
