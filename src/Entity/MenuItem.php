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
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $prijs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bestelling", mappedBy="menu_item")
     */
    private $bestellings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GerechtMenu", mappedBy="menuItem")
     */
    private $gerechtMenus;

    public function __construct()
    {
        $this->bestellings = new ArrayCollection();
        $this->gerechtMenus = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    /**
     * @return Collection|GerechtMenu[]
     */
    public function getGerechtMenus(): Collection
    {
        return $this->gerechtMenus;
    }

    public function addGerechtMenu(GerechtMenu $gerechtMenu): self
    {
        if (!$this->gerechtMenus->contains($gerechtMenu)) {
            $this->gerechtMenus[] = $gerechtMenu;
            $gerechtMenu->setMenuItem($this);
        }

        return $this;
    }

    public function removeGerechtMenu(GerechtMenu $gerechtMenu): self
    {
        if ($this->gerechtMenus->contains($gerechtMenu)) {
            $this->gerechtMenus->removeElement($gerechtMenu);
            // set the owning side to null (unless already changed)
            if ($gerechtMenu->getMenuItem() === $this) {
                $gerechtMenu->setMenuItem(null);
            }
        }

        return $this;
    }

}
