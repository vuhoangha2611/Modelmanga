<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=ModelManga::class, mappedBy="Category")
     */
    private $modelMangas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $images;

    public function __construct()
    {
        $this->modelMangas = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|ModelManga[]
     */
    public function getModelMangas(): Collection
    {
        return $this->modelMangas;
    }

    public function addModelManga(ModelManga $modelManga): self
    {
        if (!$this->modelMangas->contains($modelManga)) {
            $this->modelMangas[] = $modelManga;
            $modelManga->setCategory($this);
        }

        return $this;
    }

    public function removeModelManga(ModelManga $modelManga): self
    {
        if ($this->modelMangas->removeElement($modelManga)) {
            // set the owning side to null (unless already changed)
            if ($modelManga->getCategory() === $this) {
                $modelManga->setCategory(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

}
