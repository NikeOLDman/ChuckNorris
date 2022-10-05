<?php

namespace App\Service\JokeApi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class JokeApi
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.chucknorris.io/jokes/',
        ]);
    }

    public function getApiData(string $uri)
    {
        try {
            $response = $this->client->request('GET', $uri);
            $content = $response->getBody()->getContents();
        } catch (ClientException $e) {
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
        }
        return json_decode($content, true);
    }

    public function getData(array $config)
    {
    }
}
