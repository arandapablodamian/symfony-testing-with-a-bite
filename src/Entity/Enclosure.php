<?php

namespace App\Entity;

use App\Exception\DinosaursAreRunningRampantException;
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

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Dinosaur::class,cascade:["persist"])]
    private Collection $dinosaurs;

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Security::class,cascade :["persist"])]
    private Collection $securities;

    public function __construct(bool $withBasicSecurity = false)
    {

        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurity(new Security('Fence', true, $this));
        }

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

        if(!$this->isSecurityActive()){
            throw new DinosaursAreRunningRampantException('Are you crazyy???');
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

    /**
     * @return Collection<int, Security>
     */
    public function getSecurities(): Collection
    {
        return $this->securities;
    }

    public function addSecurity(Security $security): self
    {
        if (!$this->securities->contains($security)) {
            $this->securities->add($security);
            $security->setEnclosure($this);
        }

        return $this;
    }

    public function removeSecurity(Security $security): self
    {
        if ($this->securities->removeElement($security)) {
            // set the owning side to null (unless already changed)
            if ($security->getEnclosure() === $this) {
                $security->setEnclosure(null);
            }
        }

        return $this;
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if($security->getIsActive()) {
                return true;
            }
        }
        return false;
    }
}
