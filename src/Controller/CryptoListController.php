<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class CryptoListController extends AbstractController
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchCryptoInformation(): array
    {
        $response = $this->client->request(
            'GET',
            'https://coingecko.p.rapidapi.com/coins/markets',
            [
                'headers' => [
                    'X-RapidAPI-Host' => 'coingecko.p.rapidapi.com',
                    'X-RapidAPI-Key' => '99cc706a0amsh290c8f65b8e319cp13698cjsnb6dae4e5784a'
                ],
                'query' => [
                    'vs_currency' => 'usd',
                    'page' => '1',
                    'per_page' => '100',
                    'order' => 'market_cap_desc'
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
    #[Route('/cryptolist', name: 'app_crypto_list')]
    public function index(): Response
    {

        return $this->render('cryptolist.html.twig', [
            'controller_name' => 'CryptoListController', 'content' => $this->fetchCryptoInformation(),
        ]);
    }
}
