<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RestaurantsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RestaurantsRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Restaurants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

     // ... other fields

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="restaurants_image", fileNameProperty="imageName")
     * @Assert\Image(maxSize="8M",maxSizeMessage="Taille maximale requise 8M")
     * @var File|null
     */
    private $imageFile;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
   private $imageName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietaire;

    /**
     * @ORM\OneToMany(targetEntity=CategoriesMenu::class, mappedBy="restaurant")
     */
    private $categoriesMenus;

    /**
     * @ORM\Column(type="boolean",options={"default":false})
     */
    private $actived;

    public function __construct()
    {
        $this->categoriesMenus = new ArrayCollection();
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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    /**
     * @return Collection|CategoriesMenu[]
     */
    public function getCategoriesMenus(): Collection
    {
        return $this->categoriesMenus;
    }

    public function addCategoriesMenu(CategoriesMenu $categoriesMenu): self
    {
        if (!$this->categoriesMenus->contains($categoriesMenu)) {
            $this->categoriesMenus[] = $categoriesMenu;
            $categoriesMenu->setRestaurant($this);
        }

        return $this;
    }

    public function removeCategoriesMenu(CategoriesMenu $categoriesMenu): self
    {
        if ($this->categoriesMenus->removeElement($categoriesMenu)) {
            // set the owning side to null (unless already changed)
            if ($categoriesMenu->getRestaurant() === $this) {
                $categoriesMenu->setRestaurant(null);
            }
        }

        return $this;
    }

     /**
  
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

        public function getImageFile(): ?File
        {
            return $this->imageFile;
        }

        public function getImageName(): ?string
        {
            return $this->imageName;
        }

        public function setImageName(?string $imageName): self
        {
            $this->imageName = $imageName;

            return $this;
        }

        public function getActived(): ?bool
        {
            return $this->actived;
        }

        public function setActived(bool $actived): self
        {
            $this->actived = $actived;

            return $this;
        }
}
