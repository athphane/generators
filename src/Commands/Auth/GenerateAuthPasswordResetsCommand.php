<?php

namespace Javaabu\Generators\Commands\Auth;

use Javaabu\Generators\Generators\Auth\AuthPasswordResetsGenerator;

class GenerateAuthPasswordResetsCommand extends BaseAuthGenerateCommand
{

    protected $name = 'generate:auth_password_resets';

    protected $description = 'Generate password resets migration on your database table schema';

    protected function createOutput(string $table, array $columns, string $auth_name): void
    {
        $generator = new AuthPasswordResetsGenerator($table, $columns, $auth_name);
        $output = $generator->render();

        if (app()->runningInConsole()) {
            $this->info("Schema-based password resets migration for table \"$table\" have been generated!");
            $this->info('Copy & paste these to your migration file:');
        }

        $this->line($output);
    }

    protected function createFiles(string $table, array $columns, string $auth_name, bool $force = false, string $path = ''): void
    {
        $path = $this->getPath(database_path('migrations'), $path);

        $generator = new AuthPasswordResetsGenerator($table, $columns, $auth_name);

        $file_name = $generator->getPasswordResetsMigrationName() . '.php';
        $file_path = $this->getFullFilePath($path, $file_name);

        $output = $generator->render();

        if ($this->putContent($file_path, $output, $force)) {
            $this->info("$file_name created!");
        }
    }
}
