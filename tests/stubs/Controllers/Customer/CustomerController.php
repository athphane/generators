<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomersRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display the customer account edit page
     */
    public function edit(Request $request)
    {
        /** @var Customer $customer */
        $customer = $request->user();

        return view('customer.account.edit', compact('customer'));
    }

    /**
     * Update the customer account
     */
    public function update(CustomersRequest $request)
    {
        /** @var Customer $customer */
        $customer = $request->user();

        if ($action = $request->input('action')) {
            switch ($action) {
                case 'update_password':
                    // update password
                    if ($password = $request->input('password')) {
                        $customer->password = $password;
                        $customer->save();

                        flash_push('alerts', [
                            'text' => __('Password changed successfully'),
                            'type' => 'success',
                            'title' => __('Success!'),
                        ]);
                    }
                    break;
            }
        } else {
            // update the email
            if (($new_email = $request->email) && $new_email != $customer->email) {
                $new_email = $customer->requestEmailUpdate($new_email);
                if ($new_email) {
                    flash_push('alerts', [
                        'text' => __('We\'ve sent a verification link to :new_email. Please verify the new email address to update it', compact('new_email')),
                        'type' => 'success',
                        'title' => __('New Email Verification Sent'),
                    ]);
                }
            }

            $customer->fill($request->validated());

            if ($request->hasAny(['on_sale', 'sync_on_sale'])) {
                $customer->on_sale = $request->input('on_sale', false);
            }

            if ($request->has('category')) {
                $customer->category()->associate($request->input('category'));
            }

            $customer->save();

            // update avatar
            $customer->updateSingleMedia('avatar', $request);

            $this->flashSuccessMessage();
        }

        return $this->redirect($request, route('customer.account'));
    }
}
