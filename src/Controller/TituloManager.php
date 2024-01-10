<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Titulo;

class TituloManager extends AbstractController{

    private $APIKEY = 'Tu apiket YOUTUBE DATA API V3';
    private $maxResults = 10;

    /**
    * @Route("/titulo/{id}", name="info_titulo")
    */
    public function mostrarInfoTitulo(ManagerRegistry $doctrine, int $id, HttpClientInterface $httpClient): Response{

        $repository = $doctrine->getRepository(Titulo::class);
        $titulo = $repository->find($id);
        
        if(!$titulo){
            throw new Exception("Este Titulo no existe");
        }

        $nombreBusqueda = $titulo->getTitulo();

        if($titulo->getVideo() == ''){
            $apiURLVIDEO = 'https://www.googleapis.com/youtube/v3/search?key=' . $this->APIKEY . '&type=video&part=snippet&maxResults=' . $this->maxResults . '&q=' .$nombreBusqueda;
            $responseVIDEO = $httpClient->request('GET', $apiURLVIDEO);
            $dataVIDEO = $responseVIDEO->toArray();
            $titulo->setVideo('http://www.youtube.com/embed/' .$dataVIDEO['items'][0]['id']['videoId']);
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($titulo);
            $entityManager->flush();
        }
        
        
        $usuario = $this->getUser();
        $nombreUsuario = $usuario->getNombre();

        return $this->render('titulo/info_titulo.html.twig',[
            'nombreUsuario' => $nombreUsuario,
            'titulo_info' => $titulo
        ]);
    }

    /**
    * @Route("/{id}", name="poner_megusta")
    */
    public function ponerMeGusta(ManagerRegistry $doctrine){

        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }

        $usuario = $this->getUser();
        $nombreUsuario = $usuario->getNombre();

        $repository = $doctrine->getRepository(Titulo::class);
        $titulo = $repository->find($id);
        $mg_titulo_user = $titulo->getIdUsuarioMG();
        $foundUserId = "";

        if(count($mg_titulo_user) == 0 && $titulo->getme_gusta() == 0){
            array_push($mg_titulo_user, $usuario->getId());
            $titulo->setIdUsuarioMG($mg_titulo_user);
            $numeroMG = $titulo->getme_gusta();
            $titulo->setMeGusta($numeroMG + 1);
            dump("Igual a 0");
        }else{
            for($i = 0; $i < count($mg_titulo_user); $i++){
                if($mg_titulo_user[$i] == $usuario->getId()) {
                    $foundUserId = $usuario->getId();
                    break;
                }
            }

            if($foundUserId != "" && $foundUserId != null){
                $index = array_search($foundUserId, $mg_titulo_user);
                if($index !== false){
                    unset($mg_titulo_user[$index]);
                    $mg_titulo_user = array_values($mg_titulo_user);
                    $titulo->setIdUsuarioMG($mg_titulo_user);
                    $numeroMG = $titulo->getme_gusta();
                    $titulo->setMeGusta($numeroMG - 1);
                }
            }else{
                $foundUserId = $usuario->getId();
                    array_push($mg_titulo_user, $foundUserId);
                    $titulo->setIdUsuarioMG($mg_titulo_user);
                    $numeroMG = $titulo->getme_gusta();
                    $titulo->setMeGusta($numeroMG + 1);
            }

        }
        
        $entityManager = $doctrine->getManager();
        $entityManager->persist($titulo);
        $entityManager->flush();

        return $this->render('titulo/info_titulo.html.twig',[
            'nombreUsuario' => $nombreUsuario,
            'titulo_info' => $titulo
        ]);
    }

    /**
    * @Route("/comentar/{id}", name="comentar", methods={"POST"})
    */
    public function comentar(ManagerRegistry $doctrine, Request $request, int $id){

        try{
            $usuario = $this->getUser();
            $nombreUsuario = $usuario->getNombre();
    
            dump($request);
    
            $comentario = $request->request->get('comentario');
    
            dump($comentario);
    
            $repository = $doctrine->getRepository(Titulo::class);
            $titulo = $repository->find($id);
            
            $comentarios = $titulo->getComentario();
            $pusheo_comentarios[] = [$nombreUsuario, $comentario];
            array_push($comentarios, ...$pusheo_comentarios); 
            $titulo->setComentario($comentarios);
    
            $entityManager = $doctrine->getManager();
            $entityManager->persist($titulo);
            $entityManager->flush();
    
            dump($titulo);
    
            $this->addFlash('exito','Reseña Publicada ');
    
            return $this->render('titulo/info_titulo.html.twig',[
                'nombreUsuario' => $nombreUsuario,
                'titulo_info' => $titulo
            ]);
            
        }catch(\Exeption $e){
            return throw new \RuntimeException('Error al dejar una reseña : ' . $e->getMessage());
        }
    }

    

}

?>
