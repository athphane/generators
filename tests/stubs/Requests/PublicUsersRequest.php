<?php

namespace App\Http\Requests;

use App\Models\PublicUser;
use Javaabu\Auth\Http\Requests\UsersRequest as BaseRequest;

class PublicUsersRequest extends BaseRequest
{
    /**
     * The model morph class
     */
    protected string $morph_class = 'public_user';

    /**
     * The model table
     */
    protected string $table_name = 'public_users';

    /**
     * Check if editing current user
     */
    protected function editingCurrentUser(): bool
    {
        if ($this->user() instanceof PublicUser) {
            if ($public_user = $this->getRouteUser()) {
                return $public_user->id == $this->user()->id;
            } else {
                return if_route_pattern(['portal.*', 'api.public-user.update']);
            }
        }

        return false;
    }

    /**
     * Get the route user
     */
    protected function getRouteUser(): ?\Javaabu\Auth\User
    {
        return $this->route('public_user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = $this->baseRules(false, false);

        return $rules;
    }
}
