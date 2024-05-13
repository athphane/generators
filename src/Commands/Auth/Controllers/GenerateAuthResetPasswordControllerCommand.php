<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthResetPasswordControllerGenerator;

class GenerateAuthResetPasswordControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_reset_password_controller';

    protected $description = 'Generate auth reset password controller based on your database table schema';

    protected string $generator_class = AuthResetPasswordControllerGenerator::class;
}
