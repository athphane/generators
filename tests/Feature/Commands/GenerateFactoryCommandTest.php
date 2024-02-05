<?php

namespace Javaabu\Generators\Tests\Feature\Commands;

use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Filesystem\Filesystem;

class GenerateFactoryCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_factory_output(): void
    {
        $expected_content = $this->getTestStubContents('factories/CategoryFactory.php');

        $this->artisan('generate:factory', ['table' => 'categories'])
             ->expectsOutput($expected_content);
    }

    /** @test */
    public function it_can_generate_factory_file(): void
    {
        $expected_path = $this->app->databasePath('factories/CategoryFactory.php');
        $expected_content = $this->getTestStubContents('factories/CategoryFactory.php');

        $this->partialMock(Filesystem::class, function (MockInterface $mock) use ($expected_path, $expected_content) {
            $mock->shouldReceive('makeDirectory')
                ->andReturnTrue();

            $mock->shouldReceive('put')
                ->once()
                ->with($expected_path, $expected_content)
                ->andReturnTrue();
        });

        $this->artisan('generate:factory', ['table' => 'categories', '--create' => true])
             ->assertSuccessful();
    }
}
