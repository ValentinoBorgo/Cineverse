<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cliente;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\ClienteRepository;

class RegistroManager extends AbstractController{

    /**
    * @Route("/registroController", name="mostrar_datos")
    */
    public function registrarCliente(Request $request, UserPasswordHasherInterface $passwordHasher): Response { 
        
            if($request->getMethod() == "POST"){

                $nombre = $request->request->get('nombre_completo');
                $nombreUsuario = $request->request->get('nombre_usuario');
                $correoElectronico = $request->request->get('correo_electronico');
                $contraseña = $request->request->get('contraseña');
                $repetirContraseña = $request->request->get('repetir_contraseña');

                $clienteRepository = $this->getDoctrine()->getRepository(Cliente::class);
                $buscarDatosBD = $clienteRepository->verificarDatosRepetidos($nombre, $nombreUsuario, $correoElectronico);
                $tamanoArray = sizeof($buscarDatosBD);

                if($tamanoArray > 0){
                    $arrayValoresStrings = [];
                    for($i = 0; $i < $tamanoArray; $i++){
                        if($buscarDatosBD[$i] == $nombre || $buscarDatosBD[$i] == $nombreUsuario || $buscarDatosBD[$i] == $correoElectronico){
                            $arrayValoresStrings[] = $buscarDatosBD[$i];
                        }
                    }
                    $parseoArrayString = implode(", ", $arrayValoresStrings);
                    return $this->render('registro/registro.html.twig',['arrayValoresString' => $parseoArrayString]);
                }

                    if($contraseña === $repetirContraseña){
                        $cliente = new Cliente();
                        $cliente->setNombre($nombre);
                        $cliente->setNombreUsuario($nombreUsuario);
                        $cliente->setCorreoElectronico($correoElectronico);
                        $hashedPassword = $passwordHasher->hashPassword(
                            $cliente,
                            $contraseña
                            );                    
                        $cliente->setContraseña($hashedPassword);
                        $cliente->setRoles(['ROLE_GRATUITO']);
        
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($cliente);
                        $em-> flush();
        
                        $this->addFlash('exito','Se a registrado correctamente ' . $nombre);
                    }else{
                        $this->addFlash('error','La contraseña no coincide, vuelva a intentarlo');
                    }
                
            }
            return $this->render('registro/registro.html.twig');
        }
}


?>