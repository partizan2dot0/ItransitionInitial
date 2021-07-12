<?php


namespace App\Validator;

use App\Entity\Product;

class ProductValidator
{

    public function validate(array $productData): bool
    {
        if (self::isValidMinCostAndStock((float) $productData['Cost in GBP'], (int) $productData['Stock']) && self::isValidMaxCost((float) $productData['Cost in GBP'])){
            return true;
        }
        return false;
    }

    private function isValidMinCostAndStock(float $cost, int $stock): bool
    {
        if (( $cost < Product::MIN_COST && $stock < Product::MIN_STOCK)) {
            return false;
        }
        return true;
    }

    private function isValidMaxCost(float $cost): bool
    {
        if  ($cost > Product::MAX_COST) {
            return false;
        }
        return true;
    }

}