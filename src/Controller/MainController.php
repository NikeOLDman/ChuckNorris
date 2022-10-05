<?php

namespace App\Controller;

use App\Entity\Joke;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\JokeApi\Categories;
use App\Service\JokeApi\RandomJoke;
use App\Service\Mailer;
use App\Service\JokesCollector;

class MainController extends AbstractController
{
    private $joke;
    private $categories;
    private $randomJoke;

    public function __construct()
    {
        $this->joke = new Joke();
        $this->categories = new Categories();
        $this->randomJoke = new RandomJoke();
    }
    #[Route('/', name: 'app_main')]
    public function index(Request $request, Mailer $mailer, JokesCollector $jokesCollector): Response
    {
        $apiCategories = $this->categories->getData();

        $form = $this->createFormBuilder($this->joke)
            ->add('category', ChoiceType::class, [
                'choices'  => $apiCategories,
                'label' => 'Joke Category',
            ])
            ->add('userEmail', EmailType::class, [
                'label' => 'Your Email',
            ])
            ->add('save', SubmitType::class, ['label' => 'Get a funny joke'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->joke = $form->getData();
            $apiJoke = $this->randomJoke->getData(['category' => $this->joke->getCategory()]);
            $this->joke->setJoke($apiJoke);
            $mailer->generateEmail($this->joke);
            $jokesCollector->setData($this->joke);
            return $this->redirectToRoute('app_succes');
        }
        return $this->renderForm('main/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/succes', name: 'app_succes')]
    public function succes()
    {
        return $this->render('main/success.html.twig', [
            'success' => 'Письмо отправлено. Но это не точно.',
        ]);
    }
}
