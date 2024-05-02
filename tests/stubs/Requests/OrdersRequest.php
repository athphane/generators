<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Javaabu\Generators\Tests\TestSupport\Enums\OrderStatuses;

class OrdersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'order_no' => ['string', 'max:4'],
            'category' => ['exists:categories,id'],
            'product_slug' => ['exists:products,slug'],
            'status' => [Rule::enum(OrderStatuses::class)],
        ];

        if ($order = $this->route('order')) {
            //
        } else {
            $rules['order_no'][] = 'required';
            $rules['category'][] = 'required';
            $rules['product_slug'][] = 'required';
            $rules['status'][] = 'required';
        }

        return $rules;
    }
}
