<?php

namespace App\Entity;

use App\Repository\UnityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnityRepository::class)]
class Unity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $unity = null;

    #[ORM\ManyToMany(targetEntity: quantity::class, inversedBy: 'unities')]
    private Collection $quantity;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnity(): ?string
    {
        return $this->unity;
    }

    public function setUnity(string $unity): static
    {
        $this->unity = $unity;

        return $this;
    }

    /**
     * @return Collection<int, quantity>
     */
    public function getQuantity(): Collection
    {
        return $this->quantity;
    }

    public function addQuantity(quantity $quantity): static
    {
        if (!$this->quantity->contains($quantity)) {
            $this->quantity->add($quantity);
        }

        return $this;
    }

    public function removeQuantity(quantity $quantity): static
    {
        $this->quantity->removeElement($quantity);

        return $this;
    }
}
