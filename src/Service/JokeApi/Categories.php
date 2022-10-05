<?php

namespace App\Service\JokeApi;

use App\Service\JokeApi\JokeApi;

class Categories extends JokeApi
{
    public function getData(array $config = NULL)
    {
        $content = $this->getApiData('categories');
        foreach ($content as $item => $value) {
            $categories[$value] = $value;
        }
        return $categories;
    }
}
