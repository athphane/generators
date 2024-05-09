<?php

namespace App\Http\Controllers\Customer\Auth;

use Javaabu\Auth\User as UserContract;

class VerificationController extends \Javaabu\Auth\Http\Controllers\Auth\VerificationController
{
    public function applyMiddlewares(): void
    {
        $this->middleware('auth:web_customer');
        $this->middleware('inactive:web_customer')->except('verify');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->middleware('needs-verification')->except('show');
    }

    #[\Override]
    public function getEmailVerificationView()
    {
        return view('customer.auth.verification.verify');
    }

    #[\Override]
    public function getVerificationResultView()
    {
        return view('customer.auth.verification.result');
    }

    public function determinePathForRedirectUsing(): UserContract
    {
        return new \App\Models\Customer();
    }
}
