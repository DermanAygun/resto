<?php

namespace App\Entity;

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
     * @ORM\Column(type="datetime")
     */
    private $datum;

    /**
     * @ORM\Column(type="datetime")
     */
    private $tijd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Barman", inversedBy="bestellings")
     */
    private $barman;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservatie", inversedBy="bestellings")
     */
    private $reservatie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuItem", inversedBy="bestellings")
     */
    private $menuItem;

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

    public function getTijd(): ?\DateTimeInterface
    {
        return $this->tijd;
    }

    public function setTijd(\DateTimeInterface $tijd): self
    {
        $this->tijd = $tijd;

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

    public function getReservatie(): ?Reservatie
    {
        return $this->reservatie;
    }

    public function setReservatie(?Reservatie $reservatie): self
    {
        $this->reservatie = $reservatie;

        return $this;
    }

    public function getMenuItem(): ?MenuItem
    {
        return $this->menuItem;
    }

    public function setMenuItem(?MenuItem $menuItem): self
    {
        $this->menuItem = $menuItem;

        return $this;
    }
}
