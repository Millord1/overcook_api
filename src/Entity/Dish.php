<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishRepository::class)]
class Dish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'dishes')]
    private Collection $ingredients;

    #[ORM\OneToOne(inversedBy: 'dish', cascade: ['persist', 'remove'])]
    private ?Recipe $recipe = null;

    #[ORM\OneToMany(mappedBy: 'dish', targetEntity: Step::class)]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    /**
     * @param Ingredient[] $ingredients
     *
     * @return $this
     */
    public function addIngredients(array $ingredients): static
    {
        foreach ($ingredients as $ing){
             if (get_class($ing) === Ingredient::class && !$this->ingredients->contains($ing)) {
                $this->ingredients->add($ing);
            }
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setDish($this);
        }

        return $this;
    }

    /**
     * @param Step[] $steps
     *
     * @return $this
     */
    public function addSteps(array $steps): static
    {
        foreach ($steps as $step){
            if (get_class($step) === Step::class && !$this->steps->contains($step)) {
                $this->steps->add($step);
            }
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getDish() === $this) {
                $step->setDish(null);
            }
        }

        return $this;
    }
}
