<?php

namespace App\Entity;

use App\Repository\QuantityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuantityRepository::class)]
class Quantity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'quantity')]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Unity::class, mappedBy: 'quantity')]
    private Collection $unities;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->unities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

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
            $ingredient->addQuantity($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeQuantity($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Unity>
     */
    public function getUnities(): Collection
    {
        return $this->unities;
    }

    public function addUnity(Unity $unity): static
    {
        if (!$this->unities->contains($unity)) {
            $this->unities->add($unity);
            $unity->addQuantity($this);
        }

        return $this;
    }

    public function removeUnity(Unity $unity): static
    {
        if ($this->unities->removeElement($unity)) {
            $unity->removeQuantity($this);
        }

        return $this;
    }
}
