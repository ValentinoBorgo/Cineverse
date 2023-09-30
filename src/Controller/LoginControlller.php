<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
 /**
 * @Route("/lucky", name="app_login")
 */
    public function lucky(): Response
        {
            return $this->render('templates/base.html.twig');
        }
}


>