<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    protected $data = [
        /**
         * Categories permissions
         */
        'categories' => [
            'view_categories' => 'View categories',
            'edit_categories' => 'Edit categories',
            'delete_categories' => 'Delete categories',
        ],

        /**
         * Products permissions
         */
        'products' => [
            'view_products' => 'View products',
            'edit_products' => 'Edit products',
            'delete_products' => 'Delete products',
            'force_delete_products' => 'Permanently delete products',
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
