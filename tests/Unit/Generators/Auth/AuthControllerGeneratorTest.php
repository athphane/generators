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
        $actual_content = $controller_generator->renderController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_confirm_password_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/Auth/ConfirmPasswordController.php');
        $actual_content = $controller_generator->renderConfirmPasswordController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_forgot_password_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/Auth/ForgotPasswordController.php');
        $actual_content = $controller_generator->renderForgotPasswordController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_home_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/HomeController.php');
        $actual_content = $controller_generator->renderHomeController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_login_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/Auth/LoginController.php');
        $actual_content = $controller_generator->renderLoginController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_reset_password_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/Auth/ResetPasswordController.php');
        $actual_content = $controller_generator->renderResetPasswordController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_update_password_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/Auth/UpdatePasswordController.php');
        $actual_content = $controller_generator->renderUpdatePasswordController();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_an_auth_verification_controller(): void
    {
        $controller_generator = new AuthControllerGenerator('customers');

        $expected_content = $this->getTestStubContents('Controllers/Customer/Auth/VerificationController.php');
        $actual_content = $controller_generator->renderVerificationController();

        $this->assertEquals($expected_content, $actual_content);
    }
}
