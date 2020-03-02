<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BestellingRepository")
 */
class Bestelling
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datum;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservering", inversedBy="bestellings")
     */
    private $reservering;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuItem", inversedBy="bestellings")
     */
    private $menu_item;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bon", mappedBy="bestelling")
     */
    private $bons;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Barman", inversedBy="bestellings")
     */
    private $barman;

    public function __construct()
    {
        $this->bons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getReservering(): ?Reservering
    {
        return $this->reservering;
    }

    public function setReservering(?Reservering $reservering): self
    {
        $this->reservering = $reservering;

        return $this;
    }

    public function getMenuItem(): ?MenuItem
    {
        return $this->menu_item;
    }

    public function setMenuItem(?MenuItem $menu_item): self
    {
        $this->menu_item = $menu_item;

        return $this;
    }

    /**
     * @return Collection|Bon[]
     */
    public function getBons(): Collection
    {
        return $this->bons;
    }

    public function addBon(Bon $bon): self
    {
        if (!$this->bons->contains($bon)) {
            $this->bons[] = $bon;
            $bon->setBestelling($this);
        }

        return $this;
    }

    public function removeBon(Bon $bon): self
    {
        if ($this->bons->contains($bon)) {
            $this->bons->removeElement($bon);
            // set the owning side to null (unless already changed)
            if ($bon->getBestelling() === $this) {
                $bon->setBestelling(null);
            }
        }

        return $this;
    }

    public function getBarman(): ?Barman
    {
        return $this->barman;
    }

    public function setBarman(?Barman $barman): self
    {
        $this->barman = $barman;

        return $this;
    }
}
