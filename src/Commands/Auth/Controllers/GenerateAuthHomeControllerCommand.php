<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthHomeControllerGenerator;

class GenerateAuthHomeControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_home_controller';

    protected $description = 'Generate auth home controller based on your database table schema';

    protected string $generator_class = AuthHomeControllerGenerator::class;
}
