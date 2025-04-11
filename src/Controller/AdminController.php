<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }








    
    //CRUD pour les recettes
    #[Route('/ad_recipe', name: 'ad_recipe')]
    public function addrecipe(EntityManagerInterface $entityManager, Request $request): Response
    {
        //Ajout du formulaire dans le controller
        $recipe = new Recipe();
        
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdateAt(new \DateTimeImmutable());
            $recipe->setUser($this->getUser());

            $entityManager->persist($recipe);
            $entityManager->flush();
        }
        return $this->render('admin/addrecipe.html.twig', [
            'controller_name' => 'RecipeController',

            'form' => $form->createView(),
        ]);
    
    }


    #[Route('/list_recipe', name: 'list_recipe')]
    public function listrecipe(RecipeRepository $recipeRepository, EntityManagerInterface $entityManager): Response


    {
        $recipes = $recipeRepository->findAll();



        return $this->render('admin/list-recipes.html.twig', [
            'recipes' => $recipes,
        ]);
    }


    
    #[Route('/show_recipe', name: 'show_recipe')]
    

    public function showrecipe($id, RecipeRepository $recipeRepository, Request $request): Response


    {
        $recipe = $recipeRepository->find($id);

        return $this->render('/admin/recipe.html.twig', [
            'recipe' => $recipe,

        ]);
    }



    #[Route('/remove_recipe/{id}', name: 'remove_recipe')]
    public function removecategory($id, RecipeRepository $recipeRepository, EntityManagerInterface $entityManager): Response

    {

        $recipe = $recipeRepository->find($id);

        $entityManager->remove($recipe);
        $entityManager->flush();

        return $this->redirectToRoute('show_recipe');
    }



    #[Route('/edit_recipe/{id}', name: 'edit_recipe')]
    public function editrecipe($id, RecipeRepository $recipeRepository, EntityManagerInterface $entityManager, Request $request): Response


    {
        $recipe = $recipeRepository->find($id);
        

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($recipe);
            $entityManager->flush();
        }


        /* $product = $productRepository->find($id);
        $product->setLabel('');

        $entityManager->persist($product);
        $entityManager->flush(); { */

             return $this->render('admin/recipe.html.twig', [
                'form'=>$form->createView()
            ]);
    }






   



    #[Route('/add_category', name: 'add_category')]
    public function addCategory(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Ajoutez votre logique ici pour ajouter une catégorie
        return $this->render('admin/addcategory.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
