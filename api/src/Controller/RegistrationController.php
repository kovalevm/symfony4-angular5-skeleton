<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends ApiController
{
    /**
     * @Route("/users/register", name="user_registration", methods={"POST"})
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        try {
            /** @var User $user */
            $user = $this->deserialize(User::class, $request);
        } catch (\Exception $e) {
            return $this->createBadRequestResponse($e->getMessage());
        }

        $violations = $this->validate($user);
        if (count($violations) > 0) {
            return $this->createValidationErrorResponse($violations);
        }

        // Encode the password (you could also do this via Doctrine listener)
        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        // save the User!
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $user->eraseCredentials();

        return $this->createResponse($user);
    }
}
