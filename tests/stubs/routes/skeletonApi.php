<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);
});


/**
 * Public routes
 */
Route::group([
    'middleware' => ['oauth.client:read'],
], function () {

    /**
     * Public upload routes
     */
    //Route::post('users', ['uses' => 'UsersController@store', 'as' => 'users.store']);

    /**
     * Public JSON routes
     */
    Route::group([
        'middleware' => ['json'],
    ], function () {

        if (app()->runningUnitTests()) {
            Route::get('test', function () {
                return response()->json('It works');
            });
        }

        // Api Public Routes - DONOT REMOVE
    });
});

/**
 * Protected routes
 */
Route::group([
    'middleware' => ['auth:api', 'active:api'],
], function () {

    /**
     * User avatar
     */
    //Route::match(['PUT', 'PATCH'], 'users/profile', ['uses' => 'UsersController@update', 'as' => 'users.update']);

    /**
     * Protected JSON routes
     */
    Route::group([
        'middleware' => ['json'],
    ], function () {

        /**
         * Auth
         */
        Route::post('oauth/revoke', [UsersController::class, 'revoke']);

        /**
         * Users
         */
        Route::get('users/profile', [UsersController::class, 'profile'])->name('users.profile');
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::get('users/{id}', [UsersController::class, 'show'])->name('users.show');

    });
});
