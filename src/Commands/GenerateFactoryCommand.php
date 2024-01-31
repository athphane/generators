<?php

namespace Javaabu\Generators\Commands;

class GenerateFactoryCommand extends BaseGenerateCommand
{

    protected $name = 'generate:factory';

    protected $description = 'Generate model factory based on your database table schema';

    protected function createOutput(string $table, array $columns): void
    {
        // TODO: Implement createOutput() method.
    }

    protected function createFiles(string $table, array $columns, bool $force = false, string $path = ''): void
    {
        // TODO: Implement createFiles() method.
    }
}
