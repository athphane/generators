<?php

namespace Javaabu\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;
use Javaabu\Generators\Exceptions\ColumnDoesNotExistException;
use Javaabu\Generators\Exceptions\MultipleTablesSuppliedException;
use Javaabu\Generators\Exceptions\TableDoesNotExistException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Facades\Schema;

abstract class BaseGenerateCommand extends Command
{
    protected Filesystem $files;

    /**
     * Constructor
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function putContent(string $file_path, string $content, bool $force = false): bool
    {
        if ($this->alreadyExists($file_path) && ! $force) {
            $this->error($file_path . ' already exists!');

            return false;
        }

        $this->makeDirectory($file_path);

        $this->files->put($file_path, $content);

        return true;
    }

    protected function alreadyExists(string $path): bool
    {
        return $this->files->exists($path);
    }

    protected function makeDirectory(string $path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /** @return array */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'The table of which you want to generate from']
        ];
    }

    /** @return array */
    protected function getOptions()
    {
        return [
            ['columns', null, InputOption::VALUE_REQUIRED, 'Only generate for specific columns of the table', ''],
            ['create', 'c', InputOption::VALUE_NONE, 'Instead of outputting the generated code, create actual files'],
            ['force', 'f', InputOption::VALUE_NONE, 'If "create" was given, then the files gets created even if they already exists'],
            ['path', 'p', InputOption::VALUE_REQUIRED, 'Specify the path to create the files'],
        ];
    }

    /**
     * @throws BindingResolutionException
     * @throws MultipleTablesSuppliedException
     * @throws TableDoesNotExistException
     * @throws ColumnDoesNotExistException
     */
    public function handle(): int
    {
        // Arguments
        $table = (string) $this->argument('table');

        // Options
        $columns = (array) array_filter(explode(',', $this->option('columns')));
        $create = (bool) $this->option('create');
        $force = (bool) $this->option('force');
        $path = (string) $this->option('path');

        $this->checkTableAndColumns($table, $columns);

        if ($create) {
            $this->createFiles($table, $columns, $force, $path);
        } else {
            $this->createOutput($table, $columns);
        }

        return Command::SUCCESS;
    }


    protected abstract function createOutput(string $table, array $columns): void;

    protected abstract function createFiles(string $table, array $columns, bool $force = false, string $path = ''): void;

    /**
     * @throws MultipleTablesSuppliedException
     * @throws ColumnDoesNotExistException
     * @throws TableDoesNotExistException
     */
    protected function checkTableAndColumns(string $table, array $columns = []): void
    {
        if (count($tables = array_filter(explode(',', $table))) > 1) {
            $msg = 'The command can only handle one table at a time - you gave: '.implode(', ', $tables);

            throw new MultipleTablesSuppliedException($msg);
        }

        if (! Schema::hasTable($table)) {
            throw new TableDoesNotExistException("Table '$table' not found!");
        }

        if (empty($columns)) {
            return;
        }

        $missingColumns = [];
        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                $missingColumns[] = $column;
            }
        }

        if (! empty($missingColumns)) {
            $msg = "The following columns do not exists on the table '$table': ".implode(', ', $missingColumns);

            throw new ColumnDoesNotExistException($msg);
        }
    }
}
