<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Filesystem\Filesystem;

class GenerateControllerCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_controller_output(): void
    {
        $expected_content = $this->getTestStubContents('Controllers/CategoriesController.php');

        $this->artisan('generate:controller', ['table' => 'categories'])
             ->expectsOutput($expected_content);
    }

    /** @test */
    public function it_can_generate_controller_file(): void
    {
        $expected_path = $this->app->path('Http/Controllers/Admin/CategoriesController.php');
        $expected_content = $this->getTestStubContents('Controllers/CategoriesController.php');

        $this->partialMock(Filesystem::class, function (MockInterface $mock) use ($expected_path, $expected_content) {
            $mock->shouldReceive('makeDirectory')
                ->andReturnTrue();

            $mock->shouldReceive('put')
                ->once()
                ->with($expected_path, $expected_content)
                ->andReturnTrue();
        });

        $this->artisan('generate:controller', ['table' => 'categories', '--create' => true])
             ->assertSuccessful();
    }
}
