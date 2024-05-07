<?php

namespace Javaabu\Generators\Generators\Auth;

use Javaabu\Generators\Generators\Concerns\GeneratesPolicy;

class AuthPolicyGenerator extends BaseAuthGenerator
{
    use GeneratesPolicy;

    protected string $additional_policy_methods_stub = 'generators::Policies/_authPolicyMethods.stub';

    /**
     * Render the views
     */
    public function render(): string
    {
        return $this->renderPolicy();
    }
}
