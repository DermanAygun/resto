<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KlantRepository")
 */
class Klant
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
     * @ORM\OneToMany(targetEntity="App\Entity\Reservatie", mappedBy="klant")
     */
    private $reservaties;

    public function __construct()
    {
        $this->reservaties = new ArrayCollection();
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

    /**
     * @return Collection|Reservatie[]
     */
    public function getReservaties(): Collection
    {
        return $this->reservaties;
    }

    public function addReservaty(Reservatie $reservaty): self
    {
        if (!$this->reservaties->contains($reservaty)) {
            $this->reservaties[] = $reservaty;
            $reservaty->setKlant($this);
        }

        return $this;
    }

    public function removeReservaty(Reservatie $reservaty): self
    {
        if ($this->reservaties->contains($reservaty)) {
            $this->reservaties->removeElement($reservaty);
            // set the owning side to null (unless already changed)
            if ($reservaty->getKlant() === $this) {
                $reservaty->setKlant(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNaam();
    }
}
