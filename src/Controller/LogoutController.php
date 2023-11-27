<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    /**
    * @Route("/logout", name="app_logout", methods={"GET"})
    */
    public function logout(): void
    {
    // controller can be blank: it will never be called!
    throw new \Exception('Activate logout in security.yaml');
    }
}
