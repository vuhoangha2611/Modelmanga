<?php

namespace App\Entity;

use App\Repository\ModelMangaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelMangaRepository::class)
 */
class ModelManga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="modelMangas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CharacterName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Series;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Price;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $Material;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UsingModel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Publish_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
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

    public function getCharacterName(): ?string
    {
        return $this->CharacterName;
    }

    public function setCharacterName(string $CharacterName): self
    {
        $this->CharacterName = $CharacterName;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->Series;
    }

    public function setSeries(string $Series): self
    {
        $this->Series = $Series;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->Material;
    }

    public function setMaterial(string $Material): self
    {
        $this->Material = $Material;

        return $this;
    }

    public function getUsingModel(): ?string
    {
        return $this->UsingModel;
    }

    public function setUsingModel(string $UsingModel): self
    {
        $this->UsingModel = $UsingModel;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->Publish_date;
    }

    public function setPublishDate(?\DateTimeInterface $Publish_date): self
    {
        $this->Publish_date = $Publish_date;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
}
