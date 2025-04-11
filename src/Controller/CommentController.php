<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment')]
final class CommentController extends AbstractController
{
    #[Route('', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addcomment(EntityManagerInterface $entityManager, Request $request): Response
    
    {
    
        $comment = new Comment();
        
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUpdatedAt(new \DateTimeImmutable());
            $comment->setUser($this->getUser()); // On récupère l'utilisateur connecté et on le défini en tant qu'auteur

            $comment->setRecipe($this->getUser()); // On récupère l'utilisateur connecté et on le défini en tant qu'auteur
            $entityManager->persist($comment);
            $entityManager->flush();
        }
        return $this->render('comment/add.html.twig', [
            'controller_name' => 'RecipeController',

            'form' => $form->createView(),
        ]);
    
    }
}
