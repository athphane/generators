<?php

namespace Javaabu\Generators\Commands;

use Javaabu\Generators\Generators\BaseGenerator;

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

    protected function getGeneratorClass(): string
    {
        return property_exists($this, 'generator_class') ? $this->generator_class : '';
    }

    protected function getGenerator(string $table, array $columns): ?BaseGenerator
    {
        if ($class = $this->getGeneratorClass()) {
            return new $class($table, $columns);
        }

        return null;
    }

    protected abstract function createOutput(string $table, array $columns): void;

    protected abstract function createFiles(string $table, array $columns, bool $force = false, string $path = ''): void;
}
