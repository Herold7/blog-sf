<?php

namespace App\Controller;

use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostController extends AbstractController
{
    #[Route('/{post}/edit', name: 'post-edit')]
    public function edit(
        Request $request,
        PostRepository $postRepository,
        EntityManagerInterface $em
    ): Response {
        $post = $postRepository->findOneBy([
            'slug' => $request->get('post')
        ]); 

        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('image')->getData()) {
                $imageFile = $form->get('image')->getData();
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                    $post->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors de l\'upload de votre image');
                }
            }

            $post->setTitle($form->get('title')->getData());
            $post->setSlug($form->get('slug')->getData());
            $post->setExtract($form->get('extract')->getData());
            $post->setContent($form->get('content')->getData());
            $post->setIsPublished($form->get('isPublished')->getData());
            $post->setUpdatedAt($form->get('updated_at')->getData());
            $post->setAuthor($form->get('author')->getData());
            $post->setCategory($form->get('category')->getData());
            
            $em->persist($post);
            $em->flush();

            // Redirect to the post page
            return $this->redirectToRoute('post', [
                'post' => $post->getSlug()
            ]);
        }


        // Return the view
        return $this->render('post/edit.html.twig', [
            // Pass the post object to the view
            'post' => $post,
            'editForm' => $form
        ]);
}

// Route to add a new category
#[Route('/new-post', name: 'post_new')]
public function new(
    Request $request,
    EntityManagerInterface $em,
): Response {
    // TODO Add the form here

    // TODO Add the form proccess here

    // Return the view
    return $this->render('post/new.html.twig', [
        // Pass the form to the view
    ]);
}

// Route to delete a category
}