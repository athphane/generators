<?php

namespace Javaabu\Generators\Tests\Unit\Generators\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Generators\Generators\Auth\Controllers\AuthConfirmPasswordControllerGenerator;
use Javaabu\Generators\Tests\TestCase;

class GeneratesAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_auth_controller_name(): void
    {
        $controller_generator = new AuthConfirmPasswordControllerGenerator('customers');

        $this->assertEquals('ConfirmPasswordController', $controller_generator->getControllerName());
    }

    /** @test */
    public function it_can_generate_auth_controller_path(): void
    {
        $controller_generator = new AuthConfirmPasswordControllerGenerator('customers');

        $this->assertEquals('Http/Controllers/Customer/Auth', $controller_generator->getControllerPath());
    }
}
