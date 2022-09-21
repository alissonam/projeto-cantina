<?php

namespace Items;

/**
 * Class ItemRepository
 * @package Items
 */
class ItemRepository
{

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function index()
    {
        return Item::query();
    }
}
