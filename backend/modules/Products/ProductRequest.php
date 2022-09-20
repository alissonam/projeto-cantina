<?php

namespace Products;

use App\Http\Requests\Request;

/**
 * Class ProductRequest
 * @package Products
 */
class ProductRequest extends Request
{

    /**
     * @return string[]
     */
    public function validateToIndex()
    {
        return [
            'name'          => '',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToStore()
    {
        return [
            'name'          => 'required',
            'description'    => 'nullable',
            'price'         => 'required',
            'quantity'      => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function validateToUpdate()
    {
        return [
            'name'          => '',
            'description'    => '',
            'price'         => '',
            'quantity'      => '',
        ];
    }
}
