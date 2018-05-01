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

class UsersController extends ApiController
{
    /**
     * @Route("/users/summary", name="user_summary", methods={"GET"})
     * @return Response
     */
    public function summaryAction()
    {
        return $this->createResponse($this->getUser());
    }
}
