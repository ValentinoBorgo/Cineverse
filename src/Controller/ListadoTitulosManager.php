<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Titulo;
use App\Entity\Cliente;
use App\Repository\TituloRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime as DateTimeConstraint;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validation;
use Monolog\Utils\DateTimeImmutable;



class ListadoTitulosManager extends AbstractController
{
    private $APIKEY = 'Tu apiket de THEMOVIEDB';
    private $pag = 30;

    /**
     * @Route("/listar_titulos", name="pagina_principal")
     */
    public function listarTitulos(ManagerRegistry $doctrine, HttpClientInterface $httpClient) : Response{
        //FALTA PONER PARA USUARIO PREMIUN Y NO PREMINUN
        $repository = $doctrine->getRepository(Titulo::class);
        $titulos = $repository->findAll();
        
        if (empty($titulos)) {
            $objectManager = $doctrine->getManager();
            $this->load($httpClient, $objectManager);
        }
        
         $titulos = $this->traerDatosPorPremium($doctrine);;

        return $this->render('titulo/lista.html.twig', [
            'data' => $titulos,
            'nombreUsuario' => $this->buscarUser()
        ]);
    }

    /**
     * @Route("/filtrar_busqueda", name="busqueda")
     */
    public function filtrarPorBusqueda(Request $request, ManagerRegistry $doctrine): Response
    {

        $titulosDATA = $this->traerDatosPorPremium($doctrine);
        $busqueda = $request->query->get('busqueda');

        // Filtrar los resultados dentro de $titulosDATA que coincidan con la búsqueda
        $titulosFiltrados = array_filter($titulosDATA, function ($titulo) use ($busqueda) {
            //busca primera aparicion de una cadena 
        return stripos($titulo->getTitulo(), $busqueda) !== false;
    });

    if(!$titulosFiltrados){
        $titulosFiltrados = $this->msgError();
    }

    return $this->render('titulo/lista.html.twig', [
        'data' => $titulosFiltrados,
        'nombreUsuario' => $this->buscarUser(),
    ]);
    }


    /**
     * @Route("/filtrar_categoria/{categoria}", name="filtrado")
     */
    public function filtrarPorCategoria(Request $request, ManagerRegistry $doctrine, $categoria): Response{
        //FALTA PONER PARA USUARIO PREMIUN Y NO PREMINUN

        $titulosDATA = $this->traerDatosPorPremium($doctrine);

        if($categoria == 'tv'){
            for ($i = 0; $i < count($titulosDATA) ; $i++) { 
                if($titulosDATA[$i]->gettip() === $categoria){
                    $titulos[] = $titulosDATA[$i];
                }
            }
        }

        if($categoria == 'movie'){
            for ($i = 0; $i < count($titulosDATA) ; $i++) { 
                if($titulosDATA[$i]->gettip() === $categoria){
                    $titulos[] = $titulosDATA[$i];
                }
            }
        }

        if ($categoria == 'movie_Documentary') {
            for ($i = 0; $i < count($titulosDATA) ; $i++) {
                $movie =  $titulosDATA[$i]->gettip();
                $Documentary = $titulosDATA[$i]->getGenero();
                $movie_Documentary = $movie. '_' .$Documentary;
                if($movie_Documentary === $categoria){
                    $titulos[] = $titulosDATA[$i];
                }
            }
        }

        if ($categoria == 'all') {
            $titulos = $titulosDATA;
        }

        if(!$titulos){
            $titulos = $this->msgError();
        }
        

        return $this->render('titulo/lista.html.twig', [
            'data' => $titulos,
            'categoria' => $categoria,
            'nombreUsuario' => $this->buscarUser()
        ]);
    }


    public function load(HttpClientInterface $httpClient, ObjectManager $manager): void
    {
        //BRING ME DATA OF MOVIES TV AND DOCUMENTALS
        $apiURLMOVIES = 'https://api.themoviedb.org/3/person/popular?api_key=' . $this->APIKEY . '&page=' . $this->pag;
        $datosTitulos = [];
        
        try {
            
            $responseMOVIES = $httpClient->request('GET', $apiURLMOVIES);
            $dataMOVIES = $responseMOVIES->toArray();
            
            //Reccorer todos los datos que me devuelve la solicitud get http
            foreach($dataMOVIES['results'] as $result ){
                $titulo = new Titulo();
                $titulo->setTipo($result['known_for'][0]['media_type']);
                $titulo->setActoresPrincipales($result['name']);
                $titulo->setMeGusta(0);
                $titulo->setComentario([]);
                $roles = ['ROLE_PREMIUM', 'ROLE_GRATUITO'];
                $titulo->setPremium([$roles[array_rand($roles)]]);
                $titulo->setVideo('');

                $apiIMG = 'https://image.tmdb.org/t/p/w500' .$result['known_for'][0]['backdrop_path'];
                $titulo->setImagen($apiIMG);

                if (isset($result['known_for']) && is_array($result['known_for']) && count($result['known_for']) > 0){
                    $titulo->setDescripcion($result['known_for'][0]['overview']);
                }else{
                    $titulo->setDescripcion($result['overview']);
                }

                if (isset($result['known_for']) && is_array($result['known_for']) && count($result['known_for']) > 0) {
                    if(isset($result['known_for'][0]['release_date'])){
                        $titulo->setFechaLanzamiento($result['known_for'][0]['release_date']);
                    }else{
                        $titulo->setFechaLanzamiento($result['known_for'][0]['first_air_date']); 
                    }
                } else {
                    if(isset($result['release_date'])){
                        $titulo->setFechaLanzamiento($result['release_date']);   
                    }else{
                        $titulo->setFechaLanzamiento($result['first_air_date']);
                    }
                }
                


                //GENRESMOVIES
                //Obtengo el genero del titulo
                $apiMOVIESGENRES = 'https://api.themoviedb.org/3/movie/'. $result['id'] .'?api_key=' . $this->APIKEY;
                $responseMOVIESGENRES = $httpClient->request('GET', $apiMOVIESGENRES);
                
                if ($responseMOVIESGENRES->getStatusCode() === 200) {
                    $dataGENRES = json_decode($responseMOVIESGENRES->getContent(), true);
                
                    // Verificar si la clave 'genres' existe y si tiene elementos
                    if (isset($dataGENRES['genres']) && is_array($dataGENRES['genres']) && count($dataGENRES['genres']) > 0) {
                        // Acceder al primer elemento del array 'genres' y luego a 'name'
                        $titulo->setGenero($dataGENRES['genres'][0]['name']);
                    }else{
                        $titulo->setGenero('S/D');
                    }
                } else {
                    // Si la primera solicitud falla, intentar la segunda solicitud
                    $apiMOVIESGENRESOTHER = 'https://api.themoviedb.org/3/movie/'. $result['known_for'][0]['id'] .'?api_key=' . $this->APIKEY;
                    $responseMOVIESGENRESOTHER = $httpClient->request('GET', $apiMOVIESGENRESOTHER);
                
                    // Verificar si la segunda solicitud tuvo éxito (código 200)
                    if ($responseMOVIESGENRESOTHER->getStatusCode() === 200) {
                        $dataGENRESOTHER = json_decode($responseMOVIESGENRESOTHER->getContent(), true);
                
                        // Verificar si la clave 'genres' existe y si tiene elementos
                        if (isset($dataGENRESOTHER['genres']) && is_array($dataGENRESOTHER['genres']) && count($dataGENRESOTHER['genres']) > 0) {
                            $titulo->setGenero($dataGENRESOTHER['genres'][0]['name']);
                        }else{
                            $titulo->setGenero('S/D');
                        }
                    }
                }

                //Si las 2 solicitudes reciben el estado fallido con el status code 404(No encontrado)
                if($responseMOVIESGENRES->getStatusCode() === 404 && $responseMOVIESGENRESOTHER->getStatusCode() === 404) {
                    $titulo->setGenero('S/D');
                }
                
                

                if (isset($result['known_for'][0]) && is_array($result['known_for'][0]) && isset($result['known_for'][0]['title'])) {
                    $titulo->setTitulo($result['known_for'][0]['title']);
                    $datosTitulos[] = $titulo;
                } else {
                    $titulo->setTitulo($result['known_for'][0]['name']);
                    $datosTitulos[] = $titulo;
                }

                $manager->persist($titulo);
            }
            
            $manager-> flush();

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al cargar datos: ' . $e->getMessage());
        }
    }

    public function buscarUser(){
        $usuario = $this->getUser();
        $nombreUsuario = $usuario->getNombre();
        return $nombreUsuario;
    }

    private function traerDatosPorPremium(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Titulo::class);

        $nombreCliente = $this->buscarUser();

        $dql = 'SELECT s.fecha_caducidad FROM App\Entity\Cliente c 
        INNER JOIN c.ClienteSuscripcion s
        WHERE c.nombre = :nombreCliente';

        $entityManager = $doctrine->getManager();
        $consulta = $entityManager->createQuery($dql);
        $consulta->setParameter('nombreCliente', $nombreCliente);
        $resultados = $consulta->getResult();


        $fechaActual = new \DateTime();
        $gratuito = "ROLE_GRATUITO";
        
        //Verifica que resultados no este vacio y que se encuentre la clave 0 dentro del resultados
        if(!empty($resultados) && isset($resultados[0])){
            //Parseo de fecha en string a date
            $fechaBD = \DateTime::createFromFormat('d/m/Y', $resultados[0]['fecha_caducidad']);
            if($fechaBD >= $fechaActual){
                $titulos = $repository->findAll();
            }
            

            if($fechaBD < $fechaActual){
                //query para buscar titulos que no sean premium
                $titulos = $repository->createQueryBuilder('t')
                    ->andWhere('t.premium LIKE :rol')
                    ->setParameter('rol', '%' . json_encode($gratuito) . '%')
                    ->getQuery()
                    ->getResult();
            }
        }else{
             //query para buscar titulos que no sean premium
            $titulos = $repository->createQueryBuilder('t')
                ->andWhere('t.premium LIKE :rol')
                ->setParameter('rol', '%' . json_encode($gratuito) . '%')
                ->getQuery()
                ->getResult();
        }

        return $titulos;
        
    }

    private function msgError(){
        return $this->addFlash('error','No existe ningun titulo');
    }

}
