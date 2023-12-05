<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cliente;


Class LoginController extends AbstractController
{
    /**
    * @Route("/login", name="app_login")
    */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('login/index.html.twig', [
    'last_username' => $lastUsername,
    'error' => $error,
    ]);
 }
    /**
    * @Route("/registro", name="registro_cliente")
    */
    public function pantallaRegistrar(): Response
    {
        return $this->render('registro/registro.html.twig');
    }
 }

?>