<?php

namespace App\Entity;

use App\Entity\User;
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

    /**
     * @ORM\OneToMany(targetEntity=Tables::class, mappedBy="restaurant", orphanRemoval=true)
     */
    private $tables;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\OneToMany(targetEntity=ImagesResto::class, mappedBy="annonces", orphanRemoval=true,cascade={"persist"})
     */
    private $imagesRestos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Slug;

    public function __construct()
    {
        $this->categoriesMenus = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->imagesRestos = new ArrayCollection();
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

    public function getPropritaireName($proprietaire): ?string
    {
        return $this->$proprietaire()->getName();
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
        return $proprietaire-;
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

        /**
         * @return Collection|Tables[]
         */
        public function getTables(): Collection
        {
            return $this->tables;
        }

        public function addTable(Tables $table): self
        {
            if (!$this->tables->contains($table)) {
                $this->tables[] = $table;
                $table->setRestaurant($this);
            }

            return $this;
        }

        public function removeTable(Tables $table): self
        {
            if ($this->tables->removeElement($table)) {
                // set the owning side to null (unless already changed)
                if ($table->getRestaurant() === $this) {
                    $table->setRestaurant(null);
                }
            }

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

        public function getFacebook(): ?string
        {
            return $this->facebook;
        }

        public function setFacebook(?string $facebook): self
        {
            $this->facebook = $facebook;

            return $this;
        }

        public function getInstagram(): ?string
        {
            return $this->instagram;
        }

        public function setInstagram(?string $instagram): self
        {
            $this->instagram = $instagram;

            return $this;
        }

        public function getTelephone(): ?string
        {
            return $this->telephone;
        }

        public function setTelephone(?string $telephone): self
        {
            $this->telephone = $telephone;

            return $this;
        }

        public function getTwitter(): ?string
        {
            return $this->twitter;
        }

        public function setTwitter(?string $twitter): self
        {
            $this->twitter = $twitter;

            return $this;
        }

        /**
         * @return Collection|ImagesResto[]
         */
        public function getImagesRestos(): Collection
        {
            return $this->imagesRestos;
        }

        public function addImagesResto(ImagesResto $imagesResto): self
        {
            if (!$this->imagesRestos->contains($imagesResto)) {
                $this->imagesRestos[] = $imagesResto;
                $imagesResto->setAnnonces($this);
            }

            return $this;
        }

        public function removeImagesResto(ImagesResto $imagesResto): self
        {
            if ($this->imagesRestos->removeElement($imagesResto)) {
                // set the owning side to null (unless already changed)
                if ($imagesResto->getAnnonces() === $this) {
                    $imagesResto->setAnnonces(null);
                }
            }

            return $this;
        }

        public function getSlug(): ?string
        {
            return $this->Slug;
        }

        public function setSlug(?string $Slug): self
        {
            $this->Slug = $Slug;

            return $this;
        }
}
