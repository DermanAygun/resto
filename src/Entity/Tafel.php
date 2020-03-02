<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TafelRepository")
 */
class Tafel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nummer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gereserveerd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $personen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservering", mappedBy="tafel")
     */
    private $reserverings;

    public function __construct()
    {
        $this->reserverings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?int
    {
        return $this->nummer;
    }

    public function setNummer(int $nummer): self
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getGereserveerd(): ?bool
    {
        return $this->gereserveerd;
    }

    public function setGereserveerd(bool $gereserveerd): self
    {
        $this->gereserveerd = $gereserveerd;

        return $this;
    }

    public function getPersonen(): ?int
    {
        return $this->personen;
    }

    public function setPersonen(?int $personen): self
    {
        $this->personen = $personen;

        return $this;
    }

    /**
     * @return Collection|Reservering[]
     */
    public function getReserverings(): Collection
    {
        return $this->reserverings;
    }

    public function addReservering(Reservering $reservering): self
    {
        if (!$this->reserverings->contains($reservering)) {
            $this->reserverings[] = $reservering;
            $reservering->setTafel($this);
        }

        return $this;
    }

    public function removeReservering(Reservering $reservering): self
    {
        if ($this->reserverings->contains($reservering)) {
            $this->reserverings->removeElement($reservering);
            // set the owning side to null (unless already changed)
            if ($reservering->getTafel() === $this) {
                $reservering->setTafel(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNummer();
    }

}
