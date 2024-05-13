<?php

namespace Javaabu\Generators\Commands\Auth;

use Javaabu\Generators\Commands\GenerateCommand;
use Javaabu\Generators\Generators\Auth\BaseAuthGenerator;
use Javaabu\Generators\Generators\Auth\Controllers\AuthControllerGenerator;
use Symfony\Component\Console\Input\InputOption;

abstract class BaseAuthGenerateCommand extends GenerateCommand
{
    /** @return array */
    protected function getOptions()
    {
        $options = parent::getOptions();

        $options[] = ['auth_name', null, InputOption::VALUE_REQUIRED, 'Name used for auth routes and namespace', ''];

        return $options;
    }

    protected function runGenerator(string $table, array $columns): void
    {
        $create = (bool) $this->option('create');
        $force = (bool) $this->option('force');
        $path = (string) $this->option('path');
        $auth_name = (string) $this->option('auth_name');

        if ($create) {
            $this->createFiles($table, $columns, $auth_name, $force, $path);
        } else {
            $this->createOutput($table, $columns, $auth_name);
        }
    }

    protected function getGeneratorClass(): string
    {
        return property_exists($this, 'generator_class') ? $this->generator_class : '';
    }

    protected function getGenerator(string $table, array $columns, string $auth_name): ?BaseAuthGenerator
    {
        if ($class = $this->getGeneratorClass()) {
            return new $class($table, $columns, $auth_name);
        }

        return null;
    }

    protected abstract function createOutput(string $table, array $columns, string $auth_name): void;

    protected abstract function createFiles(string $table, array $columns, string $auth_name, bool $force = false, string $path = ''): void;


}
