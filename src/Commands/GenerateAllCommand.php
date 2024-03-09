<?php

namespace Javaabu\Generators\Commands;

use Illuminate\Support\Facades\Artisan;
use Javaabu\Generators\Generators\ControllerGenerator;
use Javaabu\Generators\Support\StringCaser;

class GenerateAllCommand extends BaseGenerateCommand
{
    protected $name = 'generate:all';

    protected $description = 'Generate all model code based on your database table schema';

    protected function createOutput(string $table, array $columns): void
    {
        $this->callCommands($table, $columns, false);
    }

    protected function createFiles(string $table, array $columns, bool $force = false, string $path = ''): void
    {
        $this->callCommands($table, $columns, true, $force, $path);
    }

    protected function callCommands(string $table, array $columns, bool $create = false, bool $force = false, string $path = ''): void
    {
        $commands = [
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

        foreach ($commands as $command) {
            Artisan::call("generate:$command", [
                'table' => $table,
                '--columns' => implode(',', $columns),
                '--create' => $create,
                '--force' => $force,
                '--path' => $path,
            ]);
        }
    }
}
