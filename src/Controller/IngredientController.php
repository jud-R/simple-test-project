<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        
        $ingredient = new Ingredient;
        
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $ingredient = $form->getData();

            $em->persist($ingredient);
            $em->flush();
            $this->addFlash('success', 'Ingredient créé! ');

            // ... perform some action, such as saving the task to the database

        }

        return $this->render('ingredient/ingredient.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
