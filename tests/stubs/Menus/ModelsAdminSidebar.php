<?php

namespace App\Menus;

use Javaabu\MenuBuilder\Menu\Menu;
use Javaabu\MenuBuilder\Menu\MenuItem;

class AdminSidebar extends Menu
{
    protected string $icon_prefix = 'zmdi ';
    protected ?string $guard = 'web_admin';

    public function menuItems(): array
    {
        return [
            MenuItem::make(__('Dashboard'))
                ->icon('zmdi-view-quilt')
                ->route('admin.home'),

            MenuItem::make(__('Products'))
                ->controller(\App\Http\Controllers\Admin\ProductsController::class)
                ->can('viewAny', \App\Models\Product::class)
                ->icon('zmdi-shopping-cart'),

            MenuItem::make(__('Categories'))
                ->controller(\App\Http\Controllers\Admin\CategoriesController::class)
                ->can('viewAny', \App\Models\Category::class)
                ->icon('zmdi-folder'),

            MenuItem::make(__('Users'))
                ->controller(\App\Http\Controllers\Admin\UsersController::class)
                ->can('viewAny', \App\Models\User::class)
                ->icon('zmdi-accounts')
                ->count(\App\Models\User::userVisible()->pending(), 'approve_users'),

            MenuItem::make(__('Roles'))
                ->controller(\App\Http\Controllers\Admin\RolesController::class)
                ->can('viewAny', \Javaabu\Permissions\Models\Role::class)
                ->icon('zmdi-folder-person'),

            MenuItem::make(__('Activity Logs'))
                ->controller(\App\Http\Controllers\Admin\LogsController::class)
                ->can('viewAny', \Javaabu\Activitylog\Models\Activity::class)
                ->icon('zmdi-assignment'),

            MenuItem::make(__('OAuth2 Clients'))
                ->controller(\App\Http\Controllers\Admin\OAuthClientsController::class)
                ->can('viewAny', \Laravel\Passport\Client::class)
                ->icon('zmdi-key'),

            MenuItem::make(__('Settings'))
                ->controller(\App\Http\Controllers\Admin\SettingsController::class)
                ->permissions('edit_settings')
                ->icon('zmdi-settings'),
        ];
    }
}
