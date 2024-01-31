<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

use Javaabu\Generators\Exceptions\ColumnDoesNotExistException;
use Javaabu\Generators\Exceptions\MultipleTablesSuppliedException;
use Javaabu\Generators\Exceptions\TableDoesNotExistException;
use Javaabu\Generators\Tests\TestCase;
use Symfony\Component\Console\Exception\RuntimeException;

class BaseGenerateCommandTest extends TestCase
{
    /** @test */
    public function it_asks_for_the_table_name(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "table")');

        $this->artisan('generate:factory');
    }

    /** @test */
    public function it_does_not_accept_multiple_table_names(): void
    {
        $this->expectException(MultipleTablesSuppliedException::class);

        $this->artisan('generate:factory', ['table' => 'categories,orders']);
    }

    /** @test */
    public function it_checks_if_the_table_exists(): void
    {
        $this->expectException(TableDoesNotExistException::class);

        $this->artisan('generate:factory', ['table' => 'none_existing_table']);
    }

    /** @test */
    public function it_checks_if_the_columns_exists(): void
    {
        $this->expectException(ColumnDoesNotExistException::class);

        $this->artisan('generate:factory', ['table' => 'products', '--columns' => 'name,none_existing_field']);
    }
}
