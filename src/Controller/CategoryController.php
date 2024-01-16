<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/{category}/new', name: 'category_edit')]
    public function index(
        // Inject the request object to get the category name
        Request $request,
        // Inject the category repository to find the category
        CategoryRepository $categoryRepository,
        // Inject the post repository to find all posts in the category
    ): Response
    {
        // Find the category by its name
        $category = $categoryRepository->findOneBy([
            'name' => $request->get('category')
        ]);

        // TODO Add the form here

        // Return the view
        return $this->render('category/index.html.twig', [
            // Pass the category object to the view
            'category' => $category,
        ]);
    }

    // Route to add a new category
    #[Route('/new-category', name: 'category_new')]
    public function new(
        // Inject the request object to get the data from the form
        Request $request,
        // Add the EntityManagerInterface to save the category
        EntityManagerInterface $em,
    ): Response
    {
        // TODO Add the form here

        // TODO Add the form proccess here

        // Return the view
        return $this->render('category/new.html.twig', [
            // Pass the form to the view
        ]);
    }

    // Route to delete a category
}