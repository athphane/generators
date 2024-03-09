<?php

namespace Javaabu\Generators\Commands;

use Javaabu\Generators\Generators\ExportGenerator;
use Javaabu\Generators\Support\StringCaser;

class GenerateExportCommand extends BaseGenerateCommand
{

    protected $name = 'generate:export';

    protected $description = 'Generate model export based on your database table schema';

    protected function createOutput(string $table, array $columns): void
    {
        $generator = new ExportGenerator($table, $columns);
        $output = $generator->render();

        if (app()->runningInConsole()) {
            $this->info("Schema-based model export for table \"$table\" have been generated!");
            $this->info('Copy & paste these to your export class:');
        }

        $this->line($output);
    }

    protected function createFiles(string $table, array $columns, bool $force = false, string $path = ''): void
    {
        $path = $this->getPath(app_path('Exports'), $path);

        $file_name = StringCaser::pluralStudly($table) . 'Export.php';
        $file_path = $this->getFullFilePath($path, $file_name);

        $generator = new ExportGenerator($table, $columns);
        $output = $generator->render();

        if ($this->putContent($file_path, $output, $force)) {
            $this->info("$file_name created!");
        }
    }
}
