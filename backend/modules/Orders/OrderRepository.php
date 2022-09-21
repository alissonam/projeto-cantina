<?php

namespace Orders;

/**
 * Class OrderRepository
 * @package Orders
 */
class OrderRepository
{

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function index()
    {
        return Order::query();
    }
}
