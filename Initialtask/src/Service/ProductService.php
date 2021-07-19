<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ProductService extends ServiceEntityRepository
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function findAll(): array
    {
        $data = $this->productRepository->findAll();

        return $data;
    }

    public function findOneBy(array $criteria): Product
    {
        return $this->productRepository->findOneBy($criteria);
    }
}
