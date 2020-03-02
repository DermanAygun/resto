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
     * @ORM\OneToMany(targetEntity="App\Entity\GerechtMenu", mappedBy="gerecht")
     */
    private $gerechtMenus;

    public function __construct()
    {
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
            $gerechtMenu->setGerecht($this);
        }

        return $this;
    }

    public function removeGerechtMenu(GerechtMenu $gerechtMenu): self
    {
        if ($this->gerechtMenus->contains($gerechtMenu)) {
            $this->gerechtMenus->removeElement($gerechtMenu);
            // set the owning side to null (unless already changed)
            if ($gerechtMenu->getGerecht() === $this) {
                $gerechtMenu->setGerecht(null);
            }
        }

        return $this;
    }

}
