<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthLoginControllerGenerator;

class GenerateAuthLoginControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_login_controller';

    protected $description = 'Generate auth login controller based on your database table schema';

    protected string $generator_class = AuthLoginControllerGenerator::class;
}
