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
use App\Entity\Cliente;
use App\Repository\SuscripcionRepository;
use App\Repository\TipoSuscripcionRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;




  class SuscripcionManager extends AbstractController
  {
      /**
       * @Route("/suscripcion", name="mostrar_suscripcion", methods={"GET", "POST"})
       */
      public function mostrarSuscripcion(Request $request,Security $security, TokenStorageInterface $tokenStorage): Response
      {
          if($request->getMethod() == "POST"){
            $mesElegido = $request->request->get('duracion_suscripcion');

            $mesesRestantes = $request->request->get('duracion_suscripcion');

            $precioElegido = $request->request->get('precio_valor');

            //obtener usuario actual
            $user = $security->getUser();
            
            $cliente = $user;

            $suscripcionRepository= $this->getDoctrine()->getRepository(Suscripcion::class);
            
            //calcula fecha de vencimiento
            $fechaVencimiento = $suscripcionRepository->calcularFechaVencimiento($mesElegido); 

            $suscripcion = new Suscripcion();

            $tipoSuscripcion = new TipoSuscripcion();
            
            $suscripcion->setFechaCaducidad($fechaVencimiento);
              if ($precioElegido !== null) {
                  $tipoSuscripcion->setPrecio($precioElegido);
              } else {
                $tipoSuscripcion->setPrecio(0);  
              }
            $tipoSuscripcion->setMesesRestantes($mesesRestantes);

            $entitym = $this->getDoctrine()->getManager();
            
            $entitym->persist($tipoSuscripcion);
            
            $entitym->persist($suscripcion);
            
            $entitym-> flush();

            $cliente->setTipoSuscripcion($tipoSuscripcion);
            $cliente->setClienteSuscripcion($suscripcion);
            $cliente->setRoles(['ROLE_PREMIUM']);
            $this->cambiarRolesYReconectar($tokenStorage, $cliente);
            $entitym->persist($cliente);
            $entitym-> flush();


            return $this->render('suscripcion/suscripcion.html.twig');
          }


          return $this->render('suscripcion/suscripcion.html.twig');

      }
    
      /**
       * @Route("/cancelar_suscripcion", name="cancelar", methods={"GET", "POST"})
       */
      public function cancelarSuscripcion(Request $request, Security $security, TokenStorageInterface $tokenStorage): Response
      {
          $user = $security->getUser();

          $cliente = $user;
              
          $entityManager = $this->getDoctrine()->getManager();

            $cliente->setTipoSuscripcion(null);

            $cliente->setClienteSuscripcion(null);
          
            $cliente->setRoles(['ROLE_GRATUITO']);

            $this->cambiarRolesYReconectar($tokenStorage, $cliente);
          
          $entityManager->persist($cliente);
          
          $entityManager->flush();

          return $this->render('suscripcion/suscripcion.html.twig',['cliente' => $cliente]);
            
      }

      private function cambiarRolesYReconectar(TokenStorageInterface $tokenStorage, Cliente $cliente)
          {
              // Desconectar al usuario
              $tokenStorage->setToken(null);

              // Cambiar roles
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($cliente);
              $entityManager->flush();

              // Volver a conectar al usuario
              $token = new UsernamePasswordToken($cliente, null, 'main', $cliente->getRoles());
              $tokenStorage->setToken($token);
          }

  }



?>