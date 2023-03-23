<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixture extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5000; $i++) {
            $recipe = new Recipe();
            $recipe->setRecipeName($faker->sentence(3, true));
            $recipe->setDuration($faker->numberBetween(10, 180));
            $recipe->setDescription($faker->paragraphs(3, true));

            // Générer des ingrédients aléatoires
            $ingredients = [];
            for ($j = 0; $j < $faker->numberBetween(2, 10); $j++) {
                $ingredient = new Ingredient();
                $ingredient->setIngredientName($faker->word);
                $ingredient->setQuantity($faker->randomFloat(2, 0.1, 10));
                $recipe->addIngredient($ingredient);
            }
            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
