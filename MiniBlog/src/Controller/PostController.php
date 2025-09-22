<?php
// src/Controller/PostController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    private function getPosts(): array
    {
        return [
            ['id' => 1, 'title' => 'My First Blog Post', 'content' => 'This is the exciting content of my very first blog post! Welcome to my blog.'],
            ['id' => 2, 'title' => 'Symfony is Amazing', 'content' => 'I just learned about Symfony MVC and it all makes sense now. The separation of concerns is so clear.'],
            ['id' => 3, 'title' => 'What is Twig?', 'content' => 'Twig is a modern, secure, and powerful templating engine for PHP. It makes writing HTML much easier.']
        ];
    }
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $posts = $this->getPosts();


        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }
    #[Route('/posts/{id}', name: 'post_show')]
    public function show(int $id): Response
    {
        $posts = $this->getPosts();

        $post = array_filter($posts, fn($post) => $post['id'] === $id);

        if (!$post) {
            throw $this->createNotFoundException('The blog post with id ' . $id . ' was not found!');
        }

        return $this->render('post/show.html.twig', [
            'post' => array_shift($post)
        ]);
    }

}
