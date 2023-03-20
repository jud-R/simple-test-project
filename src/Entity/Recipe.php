<?php

namespace App\Entity;

use App\Entity\Step;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $recipeName = null;

    #[ORM\Column]
    private ?int $step = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Ingredient::class)]
    private Collection $ingredients;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Step::class)]
    private Collection $steps;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->steps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipeName(): ?string
    {
        return $this->recipeName;
    }

    public function setRecipeName(string $recipeName): self
    {
        $this->recipeName = $recipeName;

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }
}
