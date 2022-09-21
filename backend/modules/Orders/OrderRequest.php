<?php

namespace Orders;

use App\Http\Requests\Request;

/**
 * Class OrderRequest
 * @package Orders
 */
class OrderRequest extends Request
{

    /**
     * @return string[]
     */
    public function validateToIndex()
    {
        return [
            'user_id'          => '',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToStore()
    {
        return [
            'user_id'      => 'required',
            'status'       => 'required',
            'amount'       => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToUpdate()
    {
        return [
            'user_id'      => '',
            'status'       => '',
            'amount'       => '',
        ];
    }
}
