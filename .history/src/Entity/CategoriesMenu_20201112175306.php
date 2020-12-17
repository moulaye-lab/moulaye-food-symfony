<?php

namespace App\Entity;

use App\Repository\CategoriesMenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesMenuRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class CategoriesMenu
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="categoriesMenus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=PlatMenu::class, mappedBy="categorie", orphanRemoval=true)
     */
    private $platMenus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="categoriesMenus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietaire;

    public function __construct()
    {
        $this->platMenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * updateTimestamps
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        if($this->getCreatedAt()===null){
            $this->setCreatedAt(new \DateTimeImmutable);

        }
        $this->setUpdatedAt(new \DateTimeImmutable);


    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRestaurant(): ?Restaurants
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurants $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

   

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|PlatMenu[]
     */
    public function getPlatMenus(): Collection
    {
        return $this->platMenus;
    }

    public function addPlatMenu(PlatMenu $platMenu): self
    {
        if (!$this->platMenus->contains($platMenu)) {
            $this->platMenus[] = $platMenu;
            $platMenu->setCategorie($this);
        }

        return $this;
    }

    public function removePlatMenu(PlatMenu $platMenu): self
    {
        if ($this->platMenus->removeElement($platMenu)) {
            // set the owning side to null (unless already changed)
            if ($platMenu->getCategorie() === $this) {
                $platMenu->setCategorie(null);
            }
        }

        return $this;
    }

    public function getProprietaire(): ?User
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?User $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }
}
