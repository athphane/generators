<?php

namespace Javaabu\Generators\Tests\Unit\Generators\Auth;

use Javaabu\Generators\Generators\Auth\AuthPasswordResetsGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class AuthPasswordResetsGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_the_password_resets_migration_file_name(): void
    {
        $this->travelTo('2024-04-23 12:43:31');

        $migration_generator = new AuthPasswordResetsGenerator('customers');

        $this->assertEquals('2024_04_23_124331_create_customer_password_reset_tokens_table', $migration_generator->getPasswordResetsMigrationName());
    }

    /** @test */
    public function it_can_generate_a_password_resets_migration(): void
    {
        $migration_generator = new AuthPasswordResetsGenerator('customers');

        $expected_content = $this->getTestStubContents('migrations/create_customer_password_reset_tokens_table.php');
        $actual_content = $migration_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
