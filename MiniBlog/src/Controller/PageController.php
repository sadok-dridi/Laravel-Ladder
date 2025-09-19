<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public function hello(): Response
    {
        return new Response(
            '<html><body><h1>Hello from routes.yaml!</h1></body></html>'
        );
    }
    public function about(): Response
    {
        return new Response(
            '<html><body><h1>About Us defined in routes.php!</h1></body></html>'
        );
    }
    #[Route('/contact', name: 'contact_route', methods: ['GET'])]
    public function contact(): Response
    {
        return new Response(
            '<html><body><h1>Contact Us defined via Attribute!</h1></body></html>'
        );
    }

}

