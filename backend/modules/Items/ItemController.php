<?php

namespace Items;

use App\Http\Controllers\Controller;

/**
 * Class ItemController
 * @package Items
 */
class ItemController extends Controller
{
    use ItemResponse;

    private ItemService $itemService;

    /**
     * ItemController constructor.
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * @param ItemRequest $request
     * @return mixed
     */
    public function index(ItemRequest $request)
    {
        $result = $this->itemService->index($request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param ItemRequest $request
     * @return mixed
     */
    public function store(ItemRequest $request)
    {
        $result = $this->itemService->store($request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param Item $item
     * @return mixed
     */
    public function show(Item $item)
    {
        return $this->response($item->load(\request('with') ?? [])->toArray());
    }

    /**
     * @param ItemRequest $request
     * @param Item $item
     * @return mixed
     */
    public function update(ItemRequest $request, Item $item)
    {
        $result = $this->itemService->update($item, $request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param Item $item
     * @return mixed
     */
    public function destroy(Item $item)
    {
        $result = $this->itemService->destroy($item);

        return $this->response($result['response'], $result['status']);
    }

}
