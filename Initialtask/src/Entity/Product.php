<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tblProductData")
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    public const MIN_COST = 5;

    public const MAX_COST = 1000;

    public const MIN_STOCK = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="intProductDataId", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="strProductName", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(name="strProductDesc", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(name="intStock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(name="floatCost", type="float", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $discontinued;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $added;

    /**
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=true)
     */
    private $updated;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(?float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getDiscontinued(): ?\DateTimeInterface
    {
        return $this->discontinued;
    }

    public function setDiscontinued(?\DateTimeInterface $discontinued): self
    {
        $this->discontinued = $discontinued;

        return $this;
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

    public function setAdded(?\DateTimeInterface $added): self
    {
        $this->added = $added;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
