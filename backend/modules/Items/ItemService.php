<?php

namespace Items;

use App\Http\Services\Service;

/**
 * Class ItemService
 * @package Items
 */
class ItemService extends Service
{
    /**
     * @param array $filters
     * @return array
     */
    public function index(array $filters)
    {
        $itemsQuery = ItemRepository::index($filters);

        return self::buildReturn(
            $itemsQuery
                ->with(\request()->with ?? [])
                ->paginate(\request()->perPage)
        );
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data)
    {
        $item = Item::create($data);

        return self::buildReturn($item);
    }

    /**
     * @param Item $item
     * @param array $data
     * @return array
     */
    public function update(Item $item, array $data)
    {
        $item->update($data);

        return self::buildReturn($item);
    }

    /**
     * @param Item $item
     * @return array
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return self::buildReturn();
    }
}
