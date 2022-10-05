<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Joke
{
    #[Assert\NotBlank]
    protected $category;

    protected $joke;

    #[Assert\NotBlank]
    protected $userEmail;

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getJoke(): string
    {
        return $this->joke;
    }

    public function setJoke(string $joke): void
    {
        $this->joke = $joke;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }
}
