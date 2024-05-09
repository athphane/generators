<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Javaabu\Auth\User as UserContract;

class ResetPasswordController extends \Javaabu\Auth\Http\Controllers\Auth\ResetPasswordController
{
    public function getBroker(): PasswordBroker
    {
        return Password::broker('users');
    }

    public function getGuard(): StatefulGuard
    {
        return Auth::guard('web_customer');
    }

    public function getResetFormViewName(): string
    {
        return 'customer.auth.passwords.reset';
    }

    public function determinePathForRedirectUsing(): UserContract
    {
        return new \App\Models\Customer();
    }
}
