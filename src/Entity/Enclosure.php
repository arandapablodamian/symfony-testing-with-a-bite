<?php

namespace App\Entity;

use App\Repository\EnclosureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Exception\NotABuffetException;

#[ORM\Entity(repositoryClass: EnclosureRepository::class)]
class Enclosure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Dinosaur::class)]
    private Collection $dinosaurs;

    public function __construct()
    {
        $this->dinosaurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Dinosaur>
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur): self
    {  
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }

        if (!$this->dinosaurs->contains($dinosaur)) {
            $this->dinosaurs->add($dinosaur);
            $dinosaur->setEnclosure($this);
        }

        return $this;
    }

    public function removeDinosaur(Dinosaur $dinosaur): self
    {
        if ($this->dinosaurs->removeElement($dinosaur)) {
            // set the owning side to null (unless already changed)
            if ($dinosaur->getEnclosure() === $this) {
                $dinosaur->setEnclosure(null);
            }
        }

        return $this;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }
}
