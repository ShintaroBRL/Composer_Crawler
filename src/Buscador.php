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
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array{

        $responce = $this->httpClient->request('GET',$url);
        $this->crawler->addHtmlContent($responce->getBody());
        $DOMResponse = $this->crawler->filter('span.card-curso__nome');

        $cursos = [];

        foreach ($DOMResponse as $curso) {
            $cursos[] = $curso->textContent;
        }

        return $cursos;

    }

}