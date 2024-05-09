<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\View\View;
use Javaabu\Auth\User as UserContract;

class ConfirmPasswordController extends \Javaabu\Auth\Http\Controllers\Auth\ConfirmPasswordController
{
    /**
     * Apply middlewares for the controller. Used in the constructor.
     * Helps with applying/changing applied middlewares for the controller.
     */
    public function applyMiddlewares(): void
    {
        $this->middleware('auth:web_customer');
    }

    #[\Override]
    public function getConfirmForm(): View
    {
        return view('customer.auth.passwords.confirm');
    }

    public function determinePathForRedirectUsing(): UserContract
    {
        return new \App\Models\Customer();
    }
}
