<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        // Inject the post repository to find all posts
        PostRepository $postRepository,
        // Inject the category repository to find all categories
        CategoryRepository $categoryRepository
    ): Response {
        // Return the view
        return $this->render('page/home.html.twig', [
            // Pass the page title to the view
            'posts' => $postRepository->findAll(),
            // Pass all categories to the view
            'categories' => $categoryRepository->findAll()
        ]);
    }

    // Route for displaying a single category wi
    #[Route('/{category}', name: 'category')]
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
            // Pass the category name to the view
            'title' => $category->getName(),
            // Pass all posts in the category to the view
            'posts' => $postRepository->findBy(
                [
                    'category' => $category
                ]
            )
        ]);
    }
}