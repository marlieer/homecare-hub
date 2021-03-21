<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransaction extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $product = Product::find($this->product_id);
        $max = 0;
        if($product)
        {
            $max = $product->quantity;
        }

        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => "required|numeric|min:1|max:$max",
        ];
    }
}
