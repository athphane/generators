<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

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
    /*public function it_does_not_accept_multiple_table_names(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "table")');

        $this->artisan('generate:factory');
    }*/
}
