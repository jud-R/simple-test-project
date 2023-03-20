<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredientName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredientName(): ?string
    {
        return $this->ingredientName;
    }

    public function setIngredientName(string $ingredientName): self
    {
        $this->ingredientName = $ingredientName;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
