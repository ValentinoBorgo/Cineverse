<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


Class ListadoTitulosManager extends AbstractController
{
    /**
    * @Route("/lista_titulos", name="pagina_principal")
    */
    public function paginaPrincipal(): Response
    {
        return $this->render('titulo/lista.html.twig');
    }
 }

?>