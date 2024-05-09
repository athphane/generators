<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends \Javaabu\Auth\Http\Controllers\Auth\ForgotPasswordController
{
    /**
     * Apply middlewares for the controller. Used in the constructor.
     * Helps with applying/changing applied middlewares for the controller.
     */
    public function applyMiddlewares(): void
    {
        $this->middleware('guest:web_customer');
    }

    #[\Override]
    public function getBroker(): PasswordBroker
    {
        return Password::broker('customers');
    }

    #[\Override]
    public function getPasswordResetForm(): View
    {
        return view('customer.auth.passwords.email');
    }
}
