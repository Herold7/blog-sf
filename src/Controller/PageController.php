<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(
        Request $request,
        // Inject the post repository to find all posts
        PostRepository $postRepository,
        // Inject the category repository to find all categories
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator
    ): Response {
        // Return the view
        $posts = $paginator->paginate(
        $postRepository->findAll(), // Request
        $request->query->getInt('page', 1), // Page number
         // Limit per page
        );
        return $this->render('page/home.html.twig', [
            // Pass the category object to the view
            'posts' => $posts,
            // Pass all posts in the category to the view
            'categories' => $categoryRepository->findAll()
        ]);
    }

    // Route for displaying a single category wi
    #[Route('/{category}', name: 'category', methods: ['GET'])]
    public function category(
        // Inject the request object to get the category name
        Request $request,
        // Inject the category repository to find the category
        CategoryRepository $categoryRepository,
        // Inject the post repository to find all posts in the category
        PostRepository $postRepository,
    ): Response {
        // Find the category by its name
        $category = $categoryRepository->findOneBy([
            'name' => $request->get('category')
        ]);
        
        // Return the view
        return $this->render('page/category.html.twig', [
            // Pass the category object to the view
            'category' => $category,
            // Pass all posts in the category to the view
            'posts' => $postRepository->findBy(
                [
                    'category' => $category
                ]
            )
        ]);
    }
    #[Route('/posts/{slug}', name: 'post', methods: ['GET'])]
    public function post(
        // Inject the request object to get the category name
        Request $request,
        // Inject the post repository to find all posts in the category
        PostRepository $postRepository,
    ): Response {
        // Find the post by its slug
        $post = $postRepository->findOneBy([
            'slug' => $request->get('slug')
        ]);

        return $this->render('page/post.html.twig', [
            'post' => $post,
        ]);
    }
}
