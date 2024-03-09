<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'name' => ['string', 'max:255'],
            'slug' => ['string', 'max:255'],
        ];

        $unique_name = 'unique:categories,name';
        $unique_slug = 'unique:categories,slug';

        if ($category = $this->route('category')) {
            $unique_name .= ',' . $category->getKey();
            $unique_slug .= ',' . $category->getKey();
        } else {
            $rules['name'][] = 'required';
            $rules['slug'][] = 'required';
        }

        $rules['name'][] = $unique_name;
        $rules['slug'][] = $unique_slug;

        return $rules;
    }
}
