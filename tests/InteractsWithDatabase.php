<?php

namespace Javaabu\Generators\Tests;

use Illuminate\Database\Eloquent\Model;

trait InteractsWithDatabase
{
    protected function setupDatabase()
    {
        Model::unguard();

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        include_once __DIR__ . '/database/create_categories_table.php';
        include_once __DIR__ . '/database/create_products_table.php';

        (new \CreateCategoriesTable)->up();
        (new \CreateProductsTable)->up();
    }
}
