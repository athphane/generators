<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Filesystem\Filesystem;

class GenerateApiTestCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_test_output(): void
    {
        $expected_content = $this->getTestStubContents('tests/Api/CategoriesControllerTest.stub');

        $this->artisan('generate:api_test', ['table' => 'categories'])
             ->expectsOutput($expected_content);
    }

    /** @test */
    public function it_can_generate_test_file(): void
    {
        $expected_path = $this->app->basePath('tests/Feature/Controllers/Api/CategoriesControllerTest.php');
        $expected_content = $this->getTestStubContents('tests/Api/CategoriesControllerTest.stub');

        $this->partialMock(Filesystem::class, function (MockInterface $mock) use ($expected_path, $expected_content) {
            $mock->shouldReceive('makeDirectory')
                ->andReturnTrue();

            $mock->shouldReceive('put')
                ->once()
                ->with($expected_path, $expected_content)
                ->andReturnTrue();
        });

        $this->artisan('generate:api_test', ['table' => 'categories', '--create' => true])
             ->assertSuccessful();
    }
}
