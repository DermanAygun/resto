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
     * @ORM\OneToMany(targetEntity="App\Entity\Reservatie", mappedBy="tafel")
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
            $reservaty->setTafel($this);
        }

        return $this;
    }

    public function removeReservaty(Reservatie $reservaty): self
    {
        if ($this->reservaties->contains($reservaty)) {
            $this->reservaties->removeElement($reservaty);
            // set the owning side to null (unless already changed)
            if ($reservaty->getTafel() === $this) {
                $reservaty->setTafel(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNummer();
    }

}
