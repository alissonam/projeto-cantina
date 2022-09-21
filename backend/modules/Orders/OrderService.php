<?php

namespace Orders;

use App\Http\Services\Service;

/**
 * Class OrderService
 * @package Orders
 */
class OrderService extends Service
{
    /**
     * @param array $filters
     * @return array
     */
    public function index(array $filters)
    {
        $ordersQuery = OrderRepository::index($filters);

        return self::buildReturn(
            $ordersQuery
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
        $order = Order::create($data);

        return self::buildReturn($order);
    }

    /**
     * @param Order $order
     * @param array $data
     * @return array
     */
    public function update(Order $order, array $data)
    {
        $order->update($data);

        return self::buildReturn($order);
    }

    /**
     * @param Order $order
     * @return array
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return self::buildReturn();
    }
}
