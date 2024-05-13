<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthConfirmPasswordControllerGenerator;

class GenerateAuthConfirmPasswordControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_confirm_password_controller';

    protected $description = 'Generate auth confirm password controller based on your database table schema';

    protected string $generator_class = AuthConfirmPasswordControllerGenerator::class;
}
