<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\Generators\ApiTestGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class ApiTestGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_an_api_controller_test_without_foreign_keys(): void
    {
        $api_generator = new ApiTestGenerator('categories');

        $expected_content = $this->getTestStubContents('tests/Api/CategoriesControllerTest.stub');
        $actual_content = $api_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
