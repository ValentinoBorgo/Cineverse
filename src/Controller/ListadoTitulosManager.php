<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


Class ListadoTitulosManager extends AbstractController
{
    /**
    * @Route("/listar_titulos", name="pagina_principal", methods={"GET", "PUT"})
    */
    public function paginaPrincipal(): Response
    {
        dump($this->getUser());
        return $this->render('titulo/lista.html.twig');
    }
 }

?>