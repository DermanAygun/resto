<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuItemRepository")
 */
class MenuItem
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
     * @ORM\Column(type="integer")
     */
    private $prijs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $beschrijving;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuGerecht", mappedBy="menuItem")
     */
    private $menuGerechts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bestelling", mappedBy="menuItem")
     */
    private $bestellings;

    public function __construct()
    {
        $this->menuGerechts = new ArrayCollection();
        $this->bestellings = new ArrayCollection();
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

    public function getPrijs(): ?int
    {
        return $this->prijs;
    }

    public function setPrijs(int $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
            $menuGerecht->setMenuItem($this);
        }

        return $this;
    }

    public function removeMenuGerecht(MenuGerecht $menuGerecht): self
    {
        if ($this->menuGerechts->contains($menuGerecht)) {
            $this->menuGerechts->removeElement($menuGerecht);
            // set the owning side to null (unless already changed)
            if ($menuGerecht->getMenuItem() === $this) {
                $menuGerecht->setMenuItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bestelling[]
     */
    public function getBestellings(): Collection
    {
        return $this->bestellings;
    }

    public function addBestelling(Bestelling $bestelling): self
    {
        if (!$this->bestellings->contains($bestelling)) {
            $this->bestellings[] = $bestelling;
            $bestelling->setMenuItem($this);
        }

        return $this;
    }

    public function removeBestelling(Bestelling $bestelling): self
    {
        if ($this->bestellings->contains($bestelling)) {
            $this->bestellings->removeElement($bestelling);
            // set the owning side to null (unless already changed)
            if ($bestelling->getMenuItem() === $this) {
                $bestelling->setMenuItem(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNaam();
    }
}
