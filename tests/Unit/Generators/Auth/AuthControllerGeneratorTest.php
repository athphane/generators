<?php

namespace Javaabu\Generators\Tests\Unit\Generators\Auth;

use Javaabu\Generators\Generators\Auth\AuthControllerGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Generators\Tests\TestCase;

class AuthControllerGeneratorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_an_auth_controller_with_foreign_keys(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/CustomersController.php');
        $actual_content = $controller_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
