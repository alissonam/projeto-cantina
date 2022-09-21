<?php

namespace Items;

use App\Http\Requests\Request;

/**
 * Class ItemRequest
 * @package Items
 */
class ItemRequest extends Request
{

    /**
     * @return string[]
     */
    public function validateToIndex()
    {
        return [
            'order_id'          => '',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToStore()
    {
        return [
            'order_id'       => 'required',
            'prudct_id'      => 'required',
            'subtotal'       => 'required',
            'quantity'       => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToUpdate()
    {
        return [
            'order_id'       => '',
            'prudct_id'      => '',
            'subtotal'       => '',
            'quantity'       => '',
        ];
    }
}
