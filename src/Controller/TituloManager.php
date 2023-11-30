<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Suscripcion;
use App\Entity\TipoSuscripcion;
use App\Entity\Titulo;
use App\Entity\Cliente;
use App\Repository\SuscripcionRepository;
use App\Repository\TipoSuscripcionRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TituloManager extends AbstractController{


    /**
    * @Route("/titulo/{id}", name="info_titulo")
    */
    public function mostrarInfoTitulo(ManagerRegistry $doctrine, int $id): Response{

        $usuario = $this->getUser();
        $nombreUsuario = $usuario->getNombre();

        $repository = $doctrine->getRepository(Titulo::class);
        $titulo = $repository->find($id);

        if(!$titulo){
            throw new Exception("Este Titulo no existe");
        }

        dump($titulo);

        return $this->render('titulo/info_titulo.html.twig',[
            'nombreUsuario' => $nombreUsuario,
            'titulo_info' => $titulo
        ]);
    }

}

?>