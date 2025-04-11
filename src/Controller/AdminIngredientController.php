<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;

#[Route('/admin/ingredient')]
final class AdminIngredientController extends AbstractController
{
    #[Route('', name: 'app_ingredient')]
    public function index(): Response
    {
        return $this->render('admin_ingredient/index.html.twig', [
            'controller_name' => 'AdminIngredientController',
        ]);
    }


    //CRUD pour les ingrédients

    #[Route('/add_ingredient', name: 'add_ingredient')]
    public function addIngredient(EntityManagerInterface $entityManager, Request $request): Response
    {

        $ingredient = new Ingredient();

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $entityManager->persist($ingredient);
            $entityManager->flush();
        }
        return $this->render('admin_ingredient/addingredient.html.twig', [
            'controller_name' => 'RecipeController',

            'form' => $form->createView(),
        ]);
    }

    #[Route('/list_ingredient', name: 'list_ingredient')]
    public function listingredient(IngredientRepository $ingredientRepository, EntityManagerInterface $entityManager): Response

    {
        $ingredients = $ingredientRepository->findAll();



        return $this->render('admin_ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }


#[Route('/show_ingredient/{id}', name: 'show_ingredient')]
    

    public function showingredient($id, IngredientRepository $ingredientRepository, Request $request): Response


    {


        $ingredient = $ingredientRepository->find($id);

        return $this->render('/admin_ingredient/showingredient.html.twig', [
            'ingredient' => $ingredient,

        ]);
    }


    #[Route('/edit_ingredient/{id}', name: 'edit_ingredient')]
    public function editingredient($id, IngredientRepository $ingredientRepository, EntityManagerInterface $entityManager, Request $request): Response


    {
        $ingredient = $ingredientRepository->find($id);
        

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($ingredient);
            $entityManager->flush();
        }
        return $this->render('admin_ingredient/editingredient.html.twig', [
            'form'=>$form->createView()
        ]);
}

#[Route('/remove_ingredient/{id}', name: 'remove_ingredient')]
public function removecategory($id, IngredientRepository $ingredientRepository, EntityManagerInterface $entityManager): Response

{

    $ingredient = $ingredientRepository->find($id);

    $entityManager->remove($ingredient);
    $entityManager->flush();

    return $this->redirectToRoute('list_ingredient');
}
}