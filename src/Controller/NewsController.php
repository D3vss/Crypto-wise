<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class NewsController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchNewsInformation(): array
    {
        $response = $this->client->request(
            'GET',
            'https://coinpaprika1.p.rapidapi.com/coins/btc-bitcoin/twitter',
            [
                'headers' => [
                    'X-RapidAPI-Host' => 'coinpaprika1.p.rapidapi.com',
                    'X-RapidAPI-Key' => '99cc706a0amsh290c8f65b8e319cp13698cjsnb6dae4e5784a'
                ],
            ]
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        return $content;
    }

    #[Route('/news', name: 'app_news')]
    public function index(): Response
    {
        return $this->render('news.html.twig', [
            'controller_name' => 'NewsController', 'news' => $this->fetchNewsInformation()
        ]);
    }
}
