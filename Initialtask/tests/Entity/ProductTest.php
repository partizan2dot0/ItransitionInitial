<?php

namespace App\Entity;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    private function createTestProduct(): Product
    {
        $productData = [
            'Product Name' => 'tName',
            'Product Code' => 'tCode',
            'Product Description' => 'tDesc',
            'Cost in GBP' => 25.3,
            'Stock' => 8,
            'Discontinued' => 'yes',
        ];

        $product = new Product($productData);
        $product->setAdded();

        return $product;
    }

    private function callMethod($object, string $method, array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testGetCost(): void
    {
        $this->assertIsFloat($this->createTestProduct()->getCost());
    }

    public function testGetName(): void
    {
        $this->assertIsString($this->createTestProduct()->getName());
    }

    public function testGetCode(): void
    {
        $this->assertIsString($this->createTestProduct()->getCode());
    }

    public function testGetStock(): void
    {
        $this->assertIsInt($this->createTestProduct()->getStock());
    }

    public function testGetDescription(): void
    {
        $this->assertIsString($this->createTestProduct()->getDescription());
    }

    public function testSetDescription(): void
    {
        $newDesc = 'newDescription';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setDescription', ['description' => $newDesc]);
        $this->assertEquals($testProd->getDescription(), $newDesc);
    }

    public function testSetCost(): void
    {
        $newCost = 100.55;
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setCost', ['cost' => $newCost]);
        $this->assertEquals($testProd->getCost(), $newCost);
    }

    public function testGetAdded(): void
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getAdded());
    }

    public function testSetDiscontinued(): void
    {
        $newDiscounted = 'yes';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setDiscontinued', ['discontinued' => $newDiscounted]);
        $this->assertNotEmpty($testProd->getDiscontinued());
    }

    public function testSetCode(): void
    {
        $newCode = 'newCode';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setCode', ['code' => $newCode]);
        $this->assertEquals($testProd->getCode(), $newCode);
    }

    public function testGetDiscontinued(): void
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getDiscontinued());
    }

    public function testSetAdded(): void
    {
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setAdded');
        $this->assertInstanceOf(\DateTimeImmutable::class, $testProd->getAdded());
    }

    public function testSetName(): void
    {
        $newName = 'newName';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setName', ['name' => $newName]);
        $this->assertEquals($testProd->getName(), $newName);
    }

    public function testSetStock(): void
    {
        $newStock = 333;
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setStock', ['stock' => $newStock]);
        $this->assertEquals($testProd->getStock(), $newStock);
    }
}
