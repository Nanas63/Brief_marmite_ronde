<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/category')]
final class AdminCategoryController extends AbstractController
{
    #[Route('', name: 'index_admin_category')]
    public function index(): Response
    {
        return $this->render('admin_category/index.html.twig', [
            'controller_name' => 'AdminCategoryController',
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addCategory(EntityManagerInterface $entityManager, Request $request): Response
    {

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('admin_category/addcategory.html.twig', [
            'controller_name' => 'RecipeController',

            'form' => $form->createView(),
        ]);
    }

    
}
