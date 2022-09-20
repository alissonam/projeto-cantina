<?php

namespace Products;

/**
 * Class ProductRepository
 * @package Products
 */
class ProductRepository
{

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function index()
    {
        return Product::query();
    }
}
