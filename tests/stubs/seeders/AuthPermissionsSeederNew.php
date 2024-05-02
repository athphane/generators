<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    protected $data = [
        /**
         * Public Users permissions
         */
        'public_users' => [
            'view_public_users' => 'View public users',
            'edit_public_users' => 'Edit public users',
            'delete_public_users' => 'Delete public users',
            'force_delete_public_users' => 'Permanently delete public users',
            'approve_public_users' => 'Approve public users',
        ],

        /**
         * Customers permissions
         */
        'customers' => [
            'view_customers' => 'View customers',
            'edit_customers' => 'Edit customers',
            'delete_customers' => 'Delete customers',
            'force_delete_customers' => 'Permanently delete customers',
            'approve_customers' => 'Approve customers',
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
