<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservatieRepository")
 */
class Reservatie
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
     * @ORM\Column(type="datetime")
     */
    private $datum;

    /**
     * @ORM\Column(type="datetime")
     */
    private $tijd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Klant", inversedBy="reservaties")
     */
    private $klant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tafel", inversedBy="reservaties")
     */
    private $tafel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bestelling", mappedBy="reservatie")
     */
    private $bestellings;

    public function __construct()
    {
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

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getTijd(): ?\DateTimeInterface
    {
        return $this->tijd;
    }

    public function setTijd(\DateTimeInterface $tijd): self
    {
        $this->tijd = $tijd;

        return $this;
    }

    public function getKlant(): ?Klant
    {
        return $this->klant;
    }

    public function setKlant(?Klant $klant): self
    {
        $this->klant = $klant;

        return $this;
    }

    public function getTafel(): ?Tafel
    {
        return $this->tafel;
    }

    public function setTafel(?Tafel $tafel): self
    {
        $this->tafel = $tafel;

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
            $bestelling->setReservatie($this);
        }

        return $this;
    }

    public function removeBestelling(Bestelling $bestelling): self
    {
        if ($this->bestellings->contains($bestelling)) {
            $this->bestellings->removeElement($bestelling);
            // set the owning side to null (unless already changed)
            if ($bestelling->getReservatie() === $this) {
                $bestelling->setReservatie(null);
            }
        }

        return $this;
    }
}
