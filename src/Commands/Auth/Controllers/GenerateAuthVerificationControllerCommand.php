<?php

namespace Javaabu\Generators\Commands\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\Controllers\AuthVerificationControllerGenerator;

class GenerateAuthVerificationControllerCommand extends GenerateAuthControllerCommand
{
    protected $name = 'generate:auth_verification_controller';

    protected $description = 'Generate auth verification controller based on your database table schema';

    protected string $generator_class = AuthVerificationControllerGenerator::class;
}
