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
use Knp\Component\Pager\PaginatorInterface;


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
            /** @var Recipe $recipe */
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette créée! ');
        }
        
        return $this->render('recipe/create_recipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/list', name: 'app_recipe_list')]
    public function list(Request $request, RecipeRepository $recipeRepository, PaginatorInterface $paginator): Response
    {
        // $recipes = $recipeRepository->findAll();
        
        $queryBuilder = $recipeRepository->createQueryBuilder('r')->getQuery();
        $pagination = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1), 10);


        return $this->render('recipe/list_all_recipes.html.twig', [
            'pagination' => $pagination,
        ]);
    }

#[Route('/show/{id}', name: 'app_show_recipe')]
public function show(Request $request, RecipeRepository $recipeRepository, int $id): Response
{
    $recipe = $recipeRepository->find($id);
    
    if (!$recipe) {
        $this->addFlash('danger', 'cette recette n\'existe pas!');
        return $this->redirectToRoute('app_recipe_list'); 
    }
    
    return $this->render('recipe/show_recipe.html.twig', [
        'recipe' => $recipe,
    ]);
}



}
