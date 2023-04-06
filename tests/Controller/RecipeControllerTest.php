<?php

namespace App\Tests\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/recipe');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Créer la recette')->form();
        $form['recipe[recipeName]'] = 'Test Recipe';
        $form['recipe[duration]'] = '60';
        $form['recipe[description]'] = 'This is a test recipe.';
        $client->submit($form);

        $this->assertResponseRedirects('/recipe');
    }

    public function testList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/list');

        $this->assertEquals(\Symfony\Component\HttpFoundation\Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Toutes les recettes');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $repository = static::$container->get(RecipeRepository::class);
        $entityManager = static::$container->get(EntityManagerInterface::class);

        $recipe = new Recipe();
        $recipe->setRecipeName('Test Recipe');
        $recipe->setDuration(60);
        $recipe->setDescription('This is a test recipe.');

        $entityManager->persist($recipe);
        $entityManager->flush();

        $crawler = $client->request('GET', '/show/' . $recipe->getId());

        $this->assertEquals(\Symfony\Component\HttpFoundation\Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', $recipe->getRecipeName());
    }
}

