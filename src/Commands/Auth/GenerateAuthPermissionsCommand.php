<?php

namespace Javaabu\Generators\Commands\Auth;

use Javaabu\Generators\Generators\Auth\AuthPermissionsGenerator;

class GenerateAuthPermissionsCommand extends BaseAuthGenerateCommand
{

    protected $name = 'generate:auth_permissions';

    protected $description = 'Generate auth permissions based on your database table schema';

    protected function createOutput(string $table, array $columns, string $auth_name): void
    {
        $generator = new AuthPermissionsGenerator($table, $columns, $auth_name);
        $output = $generator->render();

        if (app()->runningInConsole()) {
            $this->info("Schema-based auth permissions for table \"$table\" have been generated!");
            $this->info('Copy & paste these to your permissions seeder file:');
        }

        $this->line($output);
    }

    protected function createFiles(string $table, array $columns, string $auth_name, bool $force = false, string $path = ''): void
    {
        $path = $this->getPath(database_path('seeders'), $path);

        $stub = 'seeders/PermissionsSeeder.stub';
        $file_name = 'PermissionsSeeder.php';
        $file_path = $this->getFullFilePath($path, $file_name);

        $generator = new AuthPermissionsGenerator($table, $columns);
        $output = $generator->render();

        $replacements = [
            [
                'search' => 'protected $data = ['."\n",
                'keep_search' => true,
                'content' => $output . "\n",
            ],
        ];

        if ($this->appendContent($file_path, $replacements, $stub)) {
            $this->info("$table auth permissions created!");
        }
    }
}
