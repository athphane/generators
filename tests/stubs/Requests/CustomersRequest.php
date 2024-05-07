<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Javaabu\Auth\Http\Requests\UsersRequest as BaseRequest;
use Illuminate\Validation\Rule;

class CustomersRequest extends BaseRequest
{
    /**
     * The model morph class
     */
    protected string $morph_class = 'customer';

    /**
     * The model table
     */
    protected string $table_name = 'customers';

    /**
     * Check if editing current user
     */
    protected function editingCurrentUser(): bool
    {
        if ($this->user() instanceof Customer) {
            if ($customer = $this->getRouteUser()) {
                return $customer->id == $this->user()->id;
            } else {
                return if_route_pattern(['customer.*', 'api.customer.update']);
            }
        }

        return false;
    }

    /**
     * Get the route user
     */
    protected function getRouteUser(): ?\Javaabu\Auth\User
    {
        return $this->route('customer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = $this->baseRules();

        $rules += [
            'designation' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'on_sale' => ['boolean'],
            'expire_at' => ['date'],
            'category' => ['nullable', 'exists:categories,id'],
        ];

        $unique_designation = Rule::unique('customers', 'designation');

        if ($customer = $this->getUserBeingEdited()) {
            $unique_designation->ignore($customer->getKey());
        } else {
            $rules['designation'][] = 'required';
            $rules['address'][] = 'required';
            $rules['expire_at'][] = 'required';
        }

        $rules['designation'][] = $unique_designation;

        return $rules;
    }
}
