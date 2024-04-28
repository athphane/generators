<?php

namespace Javaabu\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;
use Javaabu\Generators\Exceptions\ColumnDoesNotExistException;
use Javaabu\Generators\Exceptions\MultipleTablesSuppliedException;
use Javaabu\Generators\Exceptions\TableDoesNotExistException;
use Javaabu\Generators\Support\StubRenderer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Facades\Schema;

abstract class BaseGenerateCommand extends GenerateCommand
{
    protected function runGenerator(string $table, array $columns): void
    {
        $create = (bool) $this->option('create');
        $force = (bool) $this->option('force');
        $path = (string) $this->option('path');

        if ($create) {
            $this->createFiles($table, $columns, $force, $path);
        } else {
            $this->createOutput($table, $columns);
        }
    }

    protected abstract function createOutput(string $table, array $columns): void;

    protected abstract function createFiles(string $table, array $columns, bool $force = false, string $path = ''): void;
}
