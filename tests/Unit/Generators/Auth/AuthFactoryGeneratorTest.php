<?php

namespace Javaabu\Generators\Tests\Unit\Generators\Auth;

use Javaabu\Generators\Generators\Auth\AuthFactoryGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class AuthFactoryGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_an_auth_factory_with_foreign_keys(): void
    {
        $factory_generator = new AuthFactoryGenerator('customers');

        $expected_content = $this->getTestStubContents('factories/CustomerFactory.php');
        $actual_content = $factory_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
