<?php

namespace App\Entity;
use App\Services\UploaderHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=Product::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="no puede estar en blanco")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="no puede estar en blanco")
     */
    private $description;


    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\NotBlank(message="no puede estar en blanco")
     * @Assert\Positive(message="no puede ser un numero negativo")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(message="no puede estar en blanco")
     * @Assert\Positive(message="no puede ser un numero negativo")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="products")
     *
     */
    private $categoria;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Image()
     */
    private $image;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getImagePath()
    {
        return 'uploads/images/'.$this->getImage();
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }




}


