<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'recipe', cascade: ['persist', 'remove'])]
    private ?Dish $dish = null;

    #[ORM\ManyToMany(targetEntity: Tags::class, mappedBy: 'recipe')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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

    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    public function setDish(?Dish $dish): static
    {
        // unset the owning side of the relation if necessary
        if ($dish === null && $this->dish !== null) {
            $this->dish->setRecipe(null);
        }

        // set the owning side of the relation if necessary
        if ($dish !== null && $dish->getRecipe() !== $this) {
            $dish->setRecipe($this);
        }

        $this->dish = $dish;

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addRecipe($this);
        }

        return $this;
    }

    /**
     * @param Tags[] $tags
     *
     * @return $this
     */
    public function addTags(array $tags): static
    {
        foreach ($tags as $tag){
            if (get_class($tag) === Tags::class && !$this->tags->contains($tag)) {
                $this->tags->add($tag);
            }
        }

        return $this;
    }


    public function removeTag(Tags $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeRecipe($this);
        }

        return $this;
    }
}
