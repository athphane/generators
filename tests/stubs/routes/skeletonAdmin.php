<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\OAuthClientsController;
use App\Http\Controllers\Admin\Auth\VerificationController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\UpdatePasswordController;
use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;

Route::group([
    'namespace' => 'Auth',
], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login-post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes...
    // Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name( 'register');
    // Route::post('register', [RegisterController::class, 'register'])->name( 'register-post');

    // Password
    Route::group([
        'prefix' => 'password',
        'as' => 'password.'
    ], function () {
        // Forgot Password
        Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
        Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
        Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
        Route::post('reset', [ResetPasswordController::class, 'reset'])->name('update');

        // Confirm Password
        Route::get('confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('confirm');
        Route::post('confirm', [ConfirmPasswordController::class, 'confirm'])->name('confirm-post');

        // Password Update
        Route::get('update', [UpdatePasswordController::class, 'showPasswordUpdateForm'])->name('new-password');
        Route::post('update', [UpdatePasswordController::class, 'updatePassword'])->name('new-password-post');
    });

    // Email Verification
    Route::group([
        'prefix' => 'verify',
        'as' => 'verification.'
    ], function () {
        Route::get('/', [VerificationController::class, 'show'])->name('notice');
        Route::post('email/resend', [VerificationController::class, 'resend'])->name('resend');
        Route::get('email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verify');
    });
});


/**
 * Protected routes
 */
Route::group([
    'middleware' => ['auth:web_admin', 'active:web_admin', 'password-update-not-required:web_admin'],
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    if (app()->runningUnitTests()) {
        Route::get('test', function () {
            return response()->json('It works');
        })->middleware('password.confirm:web_admin,admin.password.confirm');
    }

    // Generator Routes - DONOT REMOVE

    /**
     * Users
     */

    // profile
    Route::get('profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::match(['PUT', 'PATCH'], 'profile', [UsersController::class, 'updateProfile'])->name('users.profile.update');
    Route::delete('profile', [UsersController::class, 'deleteProfile'])->name('users.profile.destroy');

    Route::match(['PUT', 'PATCH'], 'users', [UsersController::class, 'bulk'])->name('users.bulk');
    Route::get('users/trash', [UsersController::class, 'trash'])->name('users.trash');
    Route::post('users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore')->withTrashed();
    Route::delete('users/{user}/force-delete', [UsersController::class, 'forceDelete'])->name('users.force-delete')->withTrashed();
    Route::resource('users', UsersController::class);

    /**
     * Roles
     */
    Route::match(['PUT', 'PATCH'], 'roles', [RolesController::class, 'bulk'])->name('roles.bulk');
    Route::resource('roles', RolesController::class);

    /**
     * Logs
     */
    Route::resource('logs', LogsController::class)->only(['index', 'show']);

    /**
     * OAuth Clients
     */
    Route::match(['PUT', 'PATCH'], 'oauth-clients', [OAuthClientsController::class, 'bulk'])->name('oauth-clients.bulk');
    Route::resource('oauth-clients', OAuthClientsController::class);

    /**
     * Routes for settings
     */
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings', [SettingsController::class, 'reset'])->name('settings.reset');
});
