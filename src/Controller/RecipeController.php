<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Form\RecipeType;
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
        // $ingredient = new Ingredient;
        
        // $formIngredient = $this->createForm(IngredientType::class, $ingredient);
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette créée! ');
        }
        
        
        return $this->render('recipe/recipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
