<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $client, Crawler $crawler)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $response = $this->client->request('GET', $url, []);

        $this->crawler->addHtmlContent($response->getBody());

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $curso) {
            $cursos[] = $curso->textContent;
        }

        return $cursos;
    }
}
