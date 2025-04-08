<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/recipe')]
final class RecipeController extends AbstractController
{
    #[Route('', name: 'index_recipe')]
    public function index(): Response
    {
        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }


    //Ajout du formulaire dans le controller
    #[Route('/add_recipe', name: 'add_recipe')]
    public function addrecipe(EntityManagerInterface $entityManager, Request $request): Response
    
    {
    
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($recipe);
            $entityManager->flush();
        }
        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',

            'form' => $form->createView(),
        ]);
    
    }
}