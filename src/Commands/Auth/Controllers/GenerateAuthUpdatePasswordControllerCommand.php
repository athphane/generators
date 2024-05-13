<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthUpdatePasswordControllerGenerator;

class GenerateAuthUpdatePasswordControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_update_password_controller';

    protected $description = 'Generate auth update password controller based on your database table schema';

    protected string $generator_class = AuthUpdatePasswordControllerGenerator::class;
}
