<?php

namespace shintaro\BuscadorCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador {
    
    /**
     *  @var ClientInterface
     */
    private $httpClient;

    /**
     *  @var Crawler
     */
    private $crawler;
    
    public function __construct(ClientInterface $httpClient, Crawler $crawler){
        $this->$httpClient = $httpClient;
        $this->$crawler = $crawler;
    }

    public function buscar(string $url = null): array{

        $responce = $httpClient->request('GET',$url);
        $crawler->addHtmlContent($responce->getBody());
        $DOMResponse = $crawler->filter('span.card-curso__nome');
        
        $cursos = [];

        foreach ($DOMResponse as $curso) {
            $cursos[] = $curso->textContent;
        }

        return $cursos;

    }

}