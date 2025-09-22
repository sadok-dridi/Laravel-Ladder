<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home_demo')] // This is the Attribute that defines the route!
    public function index(): Response
    {
        // Instead of rendering 'home/index.html.twig', we now render 'home.html.twig'
        // which extends our base template
        return $this->render('home.html.twig', [
            // We can still pass variables to the template!
            'featured_post_count' => 3
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
