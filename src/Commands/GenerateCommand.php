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

abstract class GenerateCommand extends Command
{
    protected Filesystem $files;
    protected StubRenderer $renderer;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $files = app(Filesystem::class);

        $this->files = $files;
        $this->renderer = new StubRenderer($files);
    }

    protected function getFullFilePath(string $path, string $file_name): string
    {
        return rtrim($path, '/') . '/' . $file_name;
    }

    protected function getPath(string $default, string $path = ''): string
    {
        if (! $path) {
            return $default;
        }

        return base_path($path);
    }

    protected function appendContent(string $file_path, array $contents, string $stub = ''): bool
    {
        $template = '';

        if ($this->alreadyExists($file_path)) {
            $template = $this->renderer->getFileContents($file_path);
        } elseif ($stub) {
            $template = $this->renderer->loadStub($stub);
        }

        $template = $this->renderer->appendMultipleContent($contents, $template, skip_existing: true);

        return $this->putContent($file_path, $template, true);
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

        $this->checkTableAndColumns($table, $columns);

        $this->runGenerator($table, $columns);

        return Command::SUCCESS;
    }


    protected abstract function runGenerator(string $table, array $columns): void;

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
