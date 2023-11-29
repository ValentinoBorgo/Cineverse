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




class SuscripcionManager extends AbstractController
{
 /**
 * @Route("/suscripcion", name="mostrar_suscripcion", methods={"POST", "GET"})
 */
 public function mostrarSuscripcion(Request $request,Security $security): Response
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
    $entitym->persist($cliente);
    $entitym-> flush();

    return $this->render('suscripcion/suscripcion.html.twig');
   }
   return $this->render('suscripcion/suscripcion.html.twig');

 }
 /**
 * @Route("/cancelar_suscripcion", name="cancelar_suscripcion", methods={"POST", "GET"})
 */
public function cancelarSuscripcion(Request $request, Security $security): Response
{
   $user = $security->getUser();

   $cliente = $user;
       
   $entityManager = $this->getDoctrine()->getManager();

    $cliente->setTipoSuscripcion(null);
    $cliente->setClienteSuscripcion(null);
  
    $cliente->setRoles(['ROLE_GRATUITO']);
   
   $entityManager->persist($cliente);
   
   $entityManager->flush();

   return $this->render('suscripcion/suscripcion.html.twig');
       
 }

}



?>