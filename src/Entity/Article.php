<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=160)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageSrc1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageSrc2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageSrc3;

     /**
     * @Assert\Image()
     */
    private $imageUpload1;

     /**
     * @Assert\Image()
     */
    private $imageUpload2;

     /**
     * @Assert\Image()
     */
    private $imageUpload3;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getImageSrc1(): ?string
    {
        return $this->imageSrc1;
    }

    public function setImageSrc1(string $imageSrc1): self
    {
        $this->imageSrc1 = $imageSrc1;

        return $this;
    }

    public function getImageSrc2(): ?string
    {
        return $this->imageSrc2;
    }

    public function setImageSrc2(string $imageSrc2): self
    {
        $this->imageSrc2 = $imageSrc2;

        return $this;
    }

    public function getImageSrc3(): ?string
    {
        return $this->imageSrc3;
    }

    public function setImageSrc3(string $imageSrc3): self
    {
        $this->imageSrc3 = $imageSrc3;

        return $this;
    }

public function getImageUpload1()
    {
        return $this->imageUpload1;
    }

    public function setImageUpload1($imageUpload1)
    {
        $this->imageUpload1 = $imageUpload1;
        return $this;
    }

    public function getImageUpload2()
    {
        return $this->imageUpload2;
    }

    public function setImageUpload2($imageUpload2)
    {
        $this->imageUpload2 = $imageUpload2;
        return $this;
    }

    public function getImageUpload3()
    {
        return $this->imageUpload3;
    }

    public function setImageUpload3($imageUpload3)
    {
        $this->imageUpload3 = $imageUpload3;
        return $this;
    }
}