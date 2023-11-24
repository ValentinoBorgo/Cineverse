<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cliente;


Class LoginController extends AbstractController
{
    /**
    * @Route("/login", name="app_login")
    */
    public function index(): Response
    {
        return $this->render('login/index.html.twig');
    }

    /**
    * @Route("/registro", name="registro_cliente")
    */
    public function pantallaRegistrar(): Response
    {
        return $this->render('registro/registro.html.twig');
    }

    /**
    * @Route("/mok", name="mok_datos")
    */
    public function mok(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Cliente::class);
        $mok = $repository->findAll();
         return $this->render('login/mok.html.twig', ['clientes' => $mok]);
    }

 }

?>