<?php

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Path;
use App\Entity\Joke;

class JokesCollector
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    public function setData(Joke $joke)
    {
        $fileSystem = new Filesystem();
        $publicDir = $this->kernel->getProjectDir() . '/public';
        $fileDir = $publicDir . '/Jokes';
        $date = \Date('d.m.Y H:i:s');
        try {
            $fileSystem->mkdir(
                Path::normalize($fileDir),
            );
            $fileSystem->appendToFile($fileDir . '/JokesCollector.txt', $date . ' - ' . $joke->getUserEmail() . ' - ' . $joke->getCategory() . ' - ' . $joke->getJoke() . "\n");
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }
    }
}
