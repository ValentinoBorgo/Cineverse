<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Titulo;

class ListadoTitulosManager extends AbstractController
{
    private $APIKEY = 'ef9f64bda8bdd0db0e311faeb006b5e6';

    /**
     * @Route("/lista_titulos", name="pagina_principal")
     */
    public function paginaPrincipal(HttpClientInterface $httpClient): Response
    {
        //BRING ME DATA OF MOVIES TV AND DOCUMENTALS
        $apiURLMOVIES = 'https://api.themoviedb.org/3/person/popular?api_key=' . $this->APIKEY;
        $apiURLSERIES = 'https://api.themoviedb.org/3/tv/top_rated?api_key=' . $this->APIKEY;
        $datosTitulos = [];
        
        try {

            //MOVIES
            $responseMOVIES = $httpClient->request('GET', $apiURLMOVIES);
            $dataMOVIES = $responseMOVIES->toArray();

            //SERIES
            $responseSERIES = $httpClient->request('GET', $apiURLSERIES);
            $dataSERIES = $responseSERIES->toArray();
          
            foreach($dataMOVIES['results'] as $result ){
                $titulo = new Titulo();
                $titulo->setTipo($result['known_for'][0]['media_type']);
                $titulo->setActoresPrincipales($result['name']);
                $titulo->setMeGusta(0);
                $titulo->setComentario([]);
                $titulo->setPremium([]);

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
                    } else {
                        // La clave 'genres' no está presente o está vacía, asignamos 'S/D' al atributo
                        $titulo->setGenero('S/D');
                    }
                } else {
                    // La solicitud no fue exitosa, asignamos 'S/D' al atributo
                    $titulo->setGenero('S/D');
                }


                if (isset($result['known_for'][0]) && is_array($result['known_for'][0]) && isset($result['known_for'][0]['title'])) {
                    $titulo->setTitulo($result['known_for'][0]['title']);
                    $datosTitulos[] = $titulo;
                } else {
                    $titulo->setTitulo('S/D');
                    $datosTitulos[] = $titulo;
                }
            }

            return $this->render('titulo/lista.html.twig', ['data' => $datosTitulos]);

        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
