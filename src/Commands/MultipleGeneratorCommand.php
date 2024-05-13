<?php

namespace Javaabu\Generators\Commands;

use Illuminate\Support\Facades\Artisan;

abstract class MultipleGeneratorCommand extends BaseGenerateCommand
{
    protected function getCommands(): array
    {
        return property_exists($this, 'commands') ? $this->commands : [];
    }

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
        $commands = $this->getCommands();

        foreach ($commands as $command) {
            Artisan::call("generate:$command", [
                'table' => $table,
                '--columns' => implode(',', $columns),
                '--create' => $create,
                '--force' => $force,
                '--path' => $path,
            ]);

            $this->info(Artisan::output());
        }
    }
}
