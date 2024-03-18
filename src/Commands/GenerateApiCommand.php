<?php

namespace Javaabu\Generators\Commands;

class GenerateApiCommand extends MultipleGeneratorCommand
{

    protected $name = 'generate:api';

    protected $description = 'Generate model api based on your database table schema';

    protected array $commands = [
        'api_controller',
        'api_test',
    ];
}
