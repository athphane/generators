<?php

namespace Javaabu\Generators\Tests;

trait InteractsWithDatabase
{
    protected function runMigrations()
    {
        if (! RefreshDatabaseState::$migrated) {
            $this->dropAllTables();

            include_once __DIR__ . '/database/create_categories_table.php';
            include_once __DIR__ . '/database/create_products_table.php';
            include_once __DIR__ . '/database/create_orders_table.php';
            include_once __DIR__ . '/database/create_posts_table.php';
            include_once __DIR__ . '/database/create_payments_table.php';
            include_once __DIR__ . '/database/create_certificates_table.php';
            include_once __DIR__ . '/database/create_all_foreigns_table.php';
            include_once __DIR__ . '/database/create_customers_table.php';

            (new \CreateCategoriesTable)->up();
            (new \CreateProductsTable)->up();
            (new \CreateOrdersTable)->up();
            (new \CreatePostsTable)->up();
            (new \CreatePaymentsTable)->up();
            (new \CreateCertificatesTable)->up();
            (new \CreateAllForeignsTable)->up();
            (new \CreateCustomersTable)->up();

            RefreshDatabaseState::$migrated = true;
        }
    }

    /**
     * Drop all tables
     */
    protected function dropAllTables()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        $tables = \DB::select('SHOW TABLES');
        foreach($tables as $table){
            $table = implode(json_decode(json_encode($table), true));
            \Schema::drop($table);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
