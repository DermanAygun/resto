<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GerechtRepository")
 */
class Gerecht
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $beschrijving;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuGerecht", mappedBy="gerecht")
     */
    private $menuGerechts;

    public function __construct()
    {
        $this->menuGerechts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(?string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    /**
     * @return Collection|MenuGerecht[]
     */
    public function getMenuGerechts(): Collection
    {
        return $this->menuGerechts;
    }

    public function addMenuGerecht(MenuGerecht $menuGerecht): self
    {
        if (!$this->menuGerechts->contains($menuGerecht)) {
            $this->menuGerechts[] = $menuGerecht;
            $menuGerecht->setGerecht($this);
        }

        return $this;
    }

    public function removeMenuGerecht(MenuGerecht $menuGerecht): self
    {
        if ($this->menuGerechts->contains($menuGerecht)) {
            $this->menuGerechts->removeElement($menuGerecht);
            // set the owning side to null (unless already changed)
            if ($menuGerecht->getGerecht() === $this) {
                $menuGerecht->setGerecht(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNaam();
    }
}
