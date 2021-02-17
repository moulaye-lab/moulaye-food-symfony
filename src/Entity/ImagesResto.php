<?php

namespace App\Entity;

use App\Repository\ImagesRestoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRestoRepository::class)
 */
class ImagesResto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="imagesRestos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonces;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAnnonces(): ?Restaurants
    {
        return $this->annonces;
    }

    public function setAnnonces(?Restaurants $annonces): self
    {
        $this->annonces = $annonces;

        return $this;
    }
}
