<?php

namespace App\Service\JokeApi;

use App\Service\JokeApi\JokeApi;

class RandomJoke extends JokeApi
{
    public function getData(array $config)
    {
        if (!array_key_exists('category', $config)) return false;
        $content = $this->getApiData('random?category=' . $config['category']);
        $joke = $content['value'];
        return $joke;
    }
}
