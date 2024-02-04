<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'slug' => ['string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['decimal:0,2', 'min:0', 'max:999999999999'],
            'stock' => ['integer', 'min:0', 'max:4294967295'],
            'on_sale' => ['boolean'],
            'features' => ['array'],
            'published_at' => ['date'],
            'expire_at' => ['date'],
            'released_on' => ['date'],
            'sale_time' => ['date'],
            'status' => ['in:draft,published'],
            'category' => ['nullable', 'exists:categories,id'],
            'manufactured_year' => ['integer', 'min:1900', 'max:2100'],
        ];

        $unique_slug = 'unique:products,slug';

        if ($product = $this->route('product')) {
            $unique_slug .= ',' . $product->getKey();
        } else {
            $rules['name'][] = 'required';
            $rules['address'][] = 'required';
            $rules['slug'][] = 'required';
            $rules['price'][] = 'required';
            $rules['stock'][] = 'required';
            $rules['features'][] = 'required';
            $rules['published_at'][] = 'required';
            $rules['expire_at'][] = 'required';
            $rules['released_on'][] = 'required';
            $rules['sale_time'][] = 'required';
            $rules['status'][] = 'required';
            $rules['manufactured_year'][] = 'required';
        }

        $rules['slug'][] = $unique_slug;

        return $rules;
    }
}
