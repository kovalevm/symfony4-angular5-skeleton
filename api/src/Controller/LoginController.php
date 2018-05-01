<?php

namespace App\Controller;

use App\Dto\Login;
use App\Entity\User;
use App\Service\Data\ApiAuthService;
use App\Service\Data\UsersService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends ApiController
{
    /**
     * @Route("/users/login", name="user_login", methods={"POST"})
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UsersService                 $usersService
     * @param ApiAuthService               $authService
     * @return Response
     */
    public function loginAction(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UsersService $usersService,
        ApiAuthService $authService
    ) {
        try {
            /** @var Login $login */
            $login = $this->deserialize(Login::class, $request);
        } catch (\Exception $e) {
            return $this->createBadRequestResponse($e->getMessage());
        }

        $violations = $this->validate($login);
        if (count($violations) > 0) {
            return $this->createValidationErrorResponse($violations);
        }

        $user = $usersService->findByEmail($login->getEmail());
        if ($user === null) {
            return $this->createNotFoundResponse("Not found user with such email");
        }

        $isValidPass = $passwordEncoder->isPasswordValid($user, $login->getPassword());
        if (!$isValidPass) {
            return $this->createNotFoundResponse("Incorrect password");
        }

        $jwt = $authService->generate($user,$this->getParameter('api-auth.jwt'));

        return $this->createResponse(['token' => $jwt]);
    }
}
