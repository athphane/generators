<?php

namespace Javaabu\Generators\Commands;

class GenerateAllCommand extends MultipleGeneratorCommand
{
    protected $name = 'generate:all';

    protected $description = 'Generate all model code based on your database table schema';

    protected array $commands = [
        'factory',
        'permissions',
        'model',
        'policy',
        'request',
        'export',
        'controller',
        'routes',
        'test',
        'views'
    ];
}
