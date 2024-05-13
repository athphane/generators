<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthRegisterControllerGenerator;

class GenerateAuthRegisterControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_register_controller';

    protected $description = 'Generate auth register controller based on your database table schema';

    protected string $generator_class = AuthRegisterControllerGenerator::class;
}
