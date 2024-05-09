<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Javaabu\Auth\User as UserContract;

class UpdatePasswordController extends \Javaabu\Auth\Http\Controllers\Auth\UpdatePasswordController
{
    public function applyMiddlewares(): void
    {
        $this->middleware(['auth:web_customer', 'active:web_customer', 'password-update-required:web_customer']);
    }

    #[\Override]
    public function getGuard(): StatefulGuard
    {
        return Auth::guard('web_customer');
    }

    #[\Override]
    public function getBroker(): PasswordBroker
    {
        return Password::broker('customers');
    }

    #[\Override]
    public function getPasswordUpdateForm(): View
    {
        return view('customer.auth.passwords.update');
    }

    public function determinePathForRedirectUsing(): UserContract
    {
        return new \App\Models\Customer();
    }
}
