<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Javaabu\Auth\User as UserContract;

class LoginController extends \Javaabu\Auth\Http\Controllers\Auth\LoginController
{
    public function applyMiddlewares(): void
    {
        $this->middleware('guest:web_customer')->except('logout');
    }

    public function getGuard(): StatefulGuard
    {
        return Auth::guard('web_customer');
    }

    public function getLoginForm(): View
    {
        return view('customer.auth.login');
    }

    public function determinePathForRedirectUsing(): UserContract
    {
        return new \App\Models\Customer();
    }
}
