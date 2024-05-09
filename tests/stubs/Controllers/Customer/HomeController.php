<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the customer home page
     */
    public function index(Request $request)
    {
        /** @var Customer $customer */
        $customer = $request->user();

        return view('customer.home.show', compact('customer'));
    }
}
