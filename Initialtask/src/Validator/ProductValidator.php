<?php

namespace App\Validator;

use App\Entity\Product;

class ProductValidator
{
    public static function validate(array $productData): bool
    {
        $cost = (float) preg_replace('/[^0-9.]/', '', $productData['Cost in GBP']);
        $stok = (int) preg_replace('/[^0-9]/', '', $productData['Stock']);
        if (self::isValidMinCostAndStock($cost, $stok) && self::isValidMaxCost($cost)) {
            return true;
        }

        return false;
    }

    private static function isValidMinCostAndStock(float $cost, int $stock): bool
    {
        if (($cost < Product::MIN_COST && $stock < Product::MIN_STOCK)) {
            return false;
        }

        return true;
    }

    private static function isValidMaxCost(float $cost): bool
    {
        if ($cost > Product::MAX_COST) {
            return false;
        }

        return true;
    }
}
