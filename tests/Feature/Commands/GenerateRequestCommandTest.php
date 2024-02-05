<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Filesystem\Filesystem;

class GenerateRequestCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_request_output(): void
    {
        $expected_content = $this->getTestStubContents('Requests/CategoriesRequest.php');

        $this->artisan('generate:request', ['table' => 'categories'])
             ->expectsOutput($expected_content);
    }

    /** @test */
    public function it_can_generate_request_file(): void
    {
        $expected_path = $this->app->path('Http/Requests/CategoriesRequest.php');
        $expected_content = $this->getTestStubContents('Requests/CategoriesRequest.php');

        $this->partialMock(Filesystem::class, function (MockInterface $mock) use ($expected_path, $expected_content) {
            $mock->shouldReceive('makeDirectory')
                ->andReturnTrue();

            $mock->shouldReceive('put')
                ->once()
                ->with($expected_path, $expected_content)
                ->andReturnTrue();
        });

        $this->artisan('generate:request', ['table' => 'categories', '--create' => true])
             ->assertSuccessful();
    }
}
