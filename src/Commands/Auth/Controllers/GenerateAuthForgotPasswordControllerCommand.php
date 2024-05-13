<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthForgotPasswordControllerGenerator;

class GenerateAuthForgotPasswordControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_forgot_password_controller';

    protected $description = 'Generate auth forgot password controller based on your database table schema';

    protected string $generator_class = AuthForgotPasswordControllerGenerator::class;
}
