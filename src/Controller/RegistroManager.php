<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistroManager extends AbstractController{

    /**
    * @Route("/registroController", name="mostrar_datos")
    */
    public function registrarCliente(Request $request): Response {

        if($request->getMethod() == "POST"){
            $nombre = $request->request->get('nombre_completo');
            $nombreUsuario = $request->request->get('nombre_usuario');
            $correoElectronico = $request->request->get('correo_electronico');
            $contraseña = $request->request->get('contraseña');
            $repetirContraseña = $request->request->get('repetir_contraseña');
            print_r($nombreUsuario);
            $this->addFlash('exito','Se a registrado correctamente ' . $nombre);
            return $this->render('registro/registro.html.twig');
        }

    }

    private function verificarDatosRepetidos(){

    }

}


?>