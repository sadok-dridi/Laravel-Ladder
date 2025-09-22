<?php
// src/Controller/ArticleController.php

namespace App\Controller;

use App\Entity\Article; // Import the Article entity
use Doctrine\ORM\EntityManagerInterface; // Import the EntityManager
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * CREATE - Insert a new article into the database
     * Route: /article/new
     */
    #[Route('/article/new', name: 'article_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        // 1. Create a new PHP object from the Entity class
        $article = new Article();
        // 2. Set the properties with data
        $article->setTitle('My First Doctrine Article');
        $article->setContent('This is the content saved via Doctrine!');
        $article->setAuthor('Symfony Learner');

        // 3. Persist the object (Tell Doctrine to manage it)
        $entityManager->persist($article);

        // 4. Actually execute the query (INSERT) by calling flush()
        $entityManager->flush();

        return new Response('Saved new article with id ' . $article->getId());
    }

    /**
     * READ - Fetch a specific article by its ID
     * Route: /article/{id}
     */
    #[Route('/article/{id}', name: 'article_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        // Use the find() method to get 1 article by its ID
        // Arguments: 1. The Entity class name, 2. The ID to find
        $article = $entityManager->find(Article::class, $id);

        // Check if the article was actually found
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        // For now, let's just dump the object to see it
        // In a real app, you'd pass it to a template
        return new Response('Check out this article: ' . $article->getTitle());
    }

    /**
     * READ - Fetch ALL articles by a specific user
     * This introduces the Repository and QueryBuilder!
     * Route: /author/{authorName}
     */
    #[Route('/author/{authorName}', name: 'article_by_author')]
    public function articlesByAuthor(EntityManagerInterface $entityManager, string $authorName): Response
    {
        // 1. Get the repository for the Article entity.
        // The repository is your main interface for READ queries.
        $articleRepository = $entityManager->getRepository(Article::class);

        // 2. Use the repository's `findBy` method for a simple query.
        // `findBy` returns an array of objects matching the criteria.
        $articles = $articleRepository->findBy(['author' => $authorName]);

        // 3. For more complex queries, we use the QueryBuilder.
        // Let's also find all articles by this author, ordered by newest first.
        $query = $articleRepository->createQueryBuilder('a') // 'a' is an alias for the article
        ->andWhere('a.author = :author') // :author is a parameter placeholder
        ->setParameter('author', $authorName) // Set the value for the :author parameter
        ->orderBy('a.id', 'DESC')
            ->getQuery(); // Build the query

        $articles = $query->getResult(); // Execute the query and get the results

        // Count the results
        $articleCount = count($articles);

        return new Response("Found $articleCount articles by $authorName");
    }

    /**
     * UPDATE - Update an article's title
     * Route: /article/{id}/edit
     */
    #[Route('/article/{id}/edit', name: 'article_edit')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        // 1. First, find the article you want to update
        $article = $entityManager->find(Article::class, $id);
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        // 2. Modify the object's properties.
        // That's it! The EntityManager is already "watching" this object.
        $article->setTitle('Updated Title! ' . date('h:i:s'));

        // 3. No need to call persist() again for an existing object.
        // Just call flush() to execute the UPDATE query.
        $entityManager->flush();

        return new Response('Article updated! New title is: ' . $article->getTitle());
    }

    /**
     * DELETE - Delete an article
     * Route: /article/{id}/delete
     */
    #[Route('/article/{id}/delete', name: 'article_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        // 1. First, find the article you want to delete
        $article = $entityManager->find(Article::class, $id);
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        // 2. Schedule the object for deletion
        $entityManager->remove($article);

        // 3. Execute the DELETE query
        $entityManager->flush();

        return new Response('Article with id ' . $id . ' was deleted!');
    }
    #[Route('/articles', name: 'articles_list')]
    public function list(): Response
    {
        // Sample data - in real app, this would come from a database
        $articles = [
            [
                'id' => 1,
                'title' => 'My First Article',
                'content' => 'This is the full content of my first article. It has some text here.',
                'date' => new \DateTime('2024-01-15'),
                'author' => 'John Doe'
            ],
            [
                'id' => 2,
                'title' => 'SYMFONY TUTORIAL',
                'content' => '', // Empty content to demonstrate conditional
                'date' => new \DateTime('2024-01-20'),
                'author' => 'jane smith'
            ],
            [
                'id' => 3,
                'title' => 'Twig Filters Explained',
                'content' => 'Learn how to use various Twig filters for formatting.',
                'date' => new \DateTime('2024-02-01'),
                'author' => 'alex johnson'
            ]
        ];

        return $this->render('article/list.html.twig', [
            'articles' => $articles
        ]);
    }
}
