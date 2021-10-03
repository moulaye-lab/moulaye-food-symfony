<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandesRepository::class)
 */
class Commandes
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
    private $nomPlat;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $tableResto;

    /**
     * @ORM\Column(type="integer")
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity=Tables::class, inversedBy="commandesTable",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $tablesId;

    /**
     * @ORM\Column(type="boolean",options={"default:false"})
     */
    private $servi = 0;

   
   

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPlat(): ?string
    {
        return $this->nomPlat;
    }

    public function setNomPlat(string $nomPlat): self
    {
        $this->nomPlat = $nomPlat;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTableResto()
    {
        return $this->tableResto;
    }

    public function setTableResto( $tableResto): self
    {
        $this->tableResto = $tableResto;

        return $this;
    }

    public function getRestaurant(): ?int
    {
        return $this->restaurant;
    }

    public function setRestaurant(?int $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getTablesId(): ?Tables
    {
        return $this->tablesId;
    }

    public function setTablesId(?Tables $tablesId): self
    {
        $this->tablesId = $tablesId;

        return $this;
    }

    public function getServi(): ?bool
    {
        return $this->servi;
    }

    public function setServi(bool $servi): self
    {
        $this->servi = $servi;

        return $this;
    }

   
}
