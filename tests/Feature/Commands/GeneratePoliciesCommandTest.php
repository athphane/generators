<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Filesystem\Filesystem;

class GeneratePoliciesCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_policy_output(): void
    {
        $expected_content = $this->getStubContents('Policies/CategoryPolicy.php');

        $this->artisan('generate:policy', ['table' => 'categories'])
             ->expectsOutput($expected_content);
    }

    /** @test */
    public function it_can_generate_policy_file(): void
    {
        $expected_path = $this->app->path('Policies/CategoryPolicy.php');
        $expected_content = $this->getStubContents('Policies/CategoryPolicy.php');

        $this->partialMock(Filesystem::class, function (MockInterface $mock) use ($expected_path, $expected_content) {
            $mock->shouldReceive('makeDirectory')
                ->andReturnTrue();

            $mock->shouldReceive('put')
                ->once()
                ->with($expected_path, $expected_content)
                ->andReturnTrue();
        });

        $this->artisan('generate:policy', ['table' => 'categories', '--create' => true])
             ->assertSuccessful();
    }
}
