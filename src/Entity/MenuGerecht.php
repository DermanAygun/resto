<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuGerechtRepository")
 */
class MenuGerecht
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuItem", inversedBy="menuGerechts")
     */
    private $menuItem;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gerecht", inversedBy="menuGerechts")
     */
    private $gerecht;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGerecht(): ?Gerecht
    {
        return $this->gerecht;
    }

    public function setGerecht(?Gerecht $gerecht): self
    {
        $this->gerecht = $gerecht;

        return $this;
    }
}
