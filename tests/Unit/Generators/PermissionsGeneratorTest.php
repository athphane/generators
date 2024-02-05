<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\Generators\PermissionsGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class PermissionsGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_permissions_for_soft_delete_model(): void
    {
        $permissions_generator = new PermissionsGenerator('products');

        $expected_content = $this->getTestStubContents('seeders/_permissionsSoftDeletes.stub');
        $actual_content = $permissions_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_a_permissions_for_a_none_soft_delete(): void
    {
        $permissions_generator = new PermissionsGenerator('categories');

        $expected_content = $this->getTestStubContents('seeders/_permissions.stub');
        $actual_content = $permissions_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
