<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $recipe = new Recipe();
        
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette créée! ');
        }
        
        return $this->render('recipe/create_recipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/list', name: 'app_recipe_list')]
    public function list(Request $request, RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('recipe/list_all_recipes.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/show/{id}', name: 'app_show_recipe')]
    public function show(Request $request, RecipeRepository $recipeRepository, Recipe $recipe): Response
    {
        $recipe = $recipeRepository->find($recipe);
        return $this->render('recipe/show_recipe.html.twig', [
            'recipe' => $recipe,
        ]);
    }


}
