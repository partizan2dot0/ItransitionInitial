<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use App\Validator\ProductValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="tblProductData")
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10, unique=true)
     * @Assert\NotBlank
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
     * @ORM\Column(name="intCost", type="integer", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $discontinued;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
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

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    private function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    private function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    private function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

    public function getCost(): ?float
    {
        return $this->cost/100;
    }

    private function setCost(?float $cost): void
    {
        $this->cost = intval($cost*100);
    }

    public function getDiscontinued(): ?\DateTimeInterface
    {
        return $this->discontinued;
    }

    private function setDiscontinued($discontinued): void
    {
        if ('yes' === $discontinued) {
            $this->discontinued = new \DateTimeImmutable('now');     //if discontinued setting current date
        } else {
            $this->discontinued = null;
        }
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

    /**
     * @ORM\PrePersist
     */
    public function setAdded(): void
    {
        $this->added = new \DateTimeImmutable('now');
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public static function checkConditions(array $productData): bool  // Import Rules implementation
    {
        return ProductValidator::validate($productData);
    }

    public function __construct(array $productData)
    {
//        $now = new \DateTimeImmutable('now');
        $this->setName($productData['Product Name']);
        $this->setCode($productData['Product Code']);
        $this->setDescription($productData['Product Description']);
        $this->setCost((float) $productData['Cost in GBP']);
        $this->setStock((int) $productData['Stock']);
//        $this->setAdded($now);
        $this->setDiscontinued($productData['Discontinued']);
    }
}
