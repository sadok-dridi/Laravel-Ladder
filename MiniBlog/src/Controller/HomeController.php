<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')] // This is the Attribute that defines the route!
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'name' => 'Symfony Learner' // This is the data we are passing
        ]);
    }
    #[Route('/about', name: 'about_page')]
    public function about(): JsonResponse
    {
        $data = [
            'project' => 'mvc-demo',
            'author' => 'You!',
            'version' => '1.0'
        ];


        return new JsonResponse($data);
    }
}
