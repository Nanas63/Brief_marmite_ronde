<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Entity\Ingredient;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/recipe')]
final class RecipeController extends AbstractController
{
    #[Route('', name: 'index_recipe')]
    public function index(RecipeRepository $recipeRepository, CategoryRepository $categoryRepository): Response
    {

        $recipes = $recipeRepository->findAll();
        $categories = $categoryRepository->findAll();


        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
            //'categories' => $categories,
        ]);

        
    }
    

    #[Route('/show/{id}', name: 'one_recipe')]
    public function recipe($id,RecipeRepository $recipeRepository): Response
 
    {
        $recipe= $recipeRepository->find($id);
        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        return $this->render('recipe/show.html.twig', [
            'recipe'=> $recipe,

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

            
            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdateAt(new \DateTimeImmutable());
            $recipe->setUser($this->getUser()); // On récupère l'utilisateur connecté et on le défini en tant qu'auteur
            
                     
           
            $entityManager->persist($recipe);
            $entityManager->flush();
        }
        return $this->render('recipe/add.html.twig', [
            'controller_name' => 'RecipeController',

            'form' => $form->createView(),
        ]);
    
    }

   
}