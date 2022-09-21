<?php

namespace Orders;

use App\Http\Controllers\Controller;

/**
 * Class OrderController
 * @package Orders
 */
class OrderController extends Controller
{
    use OrderResponse;

    private OrderService $orderService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param OrderRequest $request
     * @return mixed
     */
    public function index(OrderRequest $request)
    {
        $result = $this->orderService->index($request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param OrderRequest $request
     * @return mixed
     */
    public function store(OrderRequest $request)
    {
        $result = $this->orderService->store($request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function show(Order $order)
    {
        return $this->response($order->load(\request('with') ?? [])->toArray());
    }

    /**
     * @param OrderRequest $request
     * @param Order $order
     * @return mixed
     */
    public function update(OrderRequest $request, Order $order)
    {
        $result = $this->orderService->update($order, $request->validated());

        return $this->response($result['response'], $result['status']);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function destroy(Order $order)
    {
        $result = $this->orderService->destroy($order);

        return $this->response($result['response'], $result['status']);
    }

}
