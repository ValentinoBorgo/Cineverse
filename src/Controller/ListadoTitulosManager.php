<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Titulo;
use App\Repository\TituloRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class ListadoTitulosManager extends AbstractController
{
    private $APIKEY = 'ef9f64bda8bdd0db0e311faeb006b5e6';

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
    
        $titulos = $repository->findAll();

        return $this->render('titulo/lista.html.twig', [
            'data' => $titulos,
            'nombreUsuario' => $this->buscarUser()
        ]);
    }

    /**
     * @Route("/filtrar_busqueda", name="busqueda")
     */
    public function filtrarPorBusqueda(Request $request, ManagerRegistry $doctrine, $busqueda): Response
    {
        $busqueda = $request->query->get('busqueda');
        $repository = $doctrine->getRepository(Titulo::class);

        // Construir una consulta personalizada utilizando LIKE para buscar títulos similares
        $query = $repository->createQueryBuilder('t')
            ->where('t.titulo LIKE :busqueda')
            //evita inyeccion sql ya que si concateno directamente en el where es peligroso
            ->setParameter('busqueda', '%' . $busqueda . '%')
            ->getQuery();

        $titulos = $query->getResult();

        return $this->render('titulo/lista.html.twig', [
            'data' => $titulos,
            'nombreUsuario' => $this->buscarUser(),
        ]);
    }


    /**
     * @Route("/filtrar_categoria/{categoria}", name="filtrado")
     */
    public function filtrarPorCategoria(Request $request, ManagerRegistry $doctrine, $categoria): Response{
        $repository = $doctrine->getRepository(Titulo::class);
        //FALTA PONER PARA USUARIO PREMIUN Y NO PREMINUN

        if($categoria == 'tv'){
            $titulos = $repository->findBy(['tipo' => $categoria]);
        }

        if($categoria == 'movie'){
            $titulos = $repository->findBy(['tipo' => $categoria]); 
        }

        if ($categoria == 'movie_Documentary') {
            $titulos = $repository->findBy(['tipo' => 'movie', 'genero' => 'Documentary']);
        }

        if ($categoria == 'all') {
            $titulos = $repository->findAll();
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
        $apiURLMOVIES = 'https://api.themoviedb.org/3/person/popular?api_key=' . $this->APIKEY;
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
                $titulo->setPremium([]);
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

}
