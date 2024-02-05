<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    protected $data = [
        /**
         * Users permissions
         */
        'users' => [
            'view_users' => 'View users',
            'edit_users' => 'Edit users',
            'approve_users' => 'Approve users',
            'delete_users' => 'Delete users',
            'force_delete_users' => 'Permanently delete users',
        ],

        /**
         * OAuth Clients permissions
         */
        'oauth_clients' => [
            'view_oauth_clients' => 'View OAuth2 clients',
            'edit_oauth_clients' => 'Edit own OAuth2 clients',
            'edit_others_oauth_clients' => 'Edit all OAuth2 clients',
            'delete_oauth_clients' => 'Delete own OAuth2 clients',
            'delete_others_oauth_clients' => 'Delete all OAuth2 clients',
        ],

        /**
         * Roles permissions
         */
        'roles' => [
            'view_roles' => 'View roles',
            'edit_roles' => 'Edit roles',
            'delete_roles' => 'Delete roles',
        ],

        /**
         * Activity log permissions
         */
        'logs' => [
            'view_logs' => 'View logs of authorized models',
            'view_all_logs' => 'View all logs',
        ],

        /**
         * Settings permissions
         */
        'settings' => [
            'edit_settings' => 'Edit settings',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $model => $permissions) {
            foreach ($permissions as $name => $desc) {
                $permission = Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web_admin']);
                $permission->update(['description' => $desc, 'model' => $model]);
                $permission->save();
            }
        }
    }
}
