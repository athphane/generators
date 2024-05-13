<?php

namespace Javaabu\Generators\Commands\Auth;

use Javaabu\Generators\Generators\Auth\AuthConfigGenerator;

class GenerateAuthConfigCommand extends BaseAuthGenerateCommand
{

    protected $name = 'generate:auth_config';

    protected $description = 'Generate auth config based on your database table schema';

    protected string $generator_class = AuthConfigGenerator::class;

    protected function createOutput(string $table, array $columns, string $auth_name): void
    {
        $generator = $this->getGenerator($table, $columns, $auth_name);
        $output = $generator->render();

        if (app()->runningInConsole()) {
            $this->info("Schema-based auth config for table \"$table\" have been generated!");
            $this->info('Copy & paste these to your auth config file:');
        }

        $this->line($output);
    }

    protected function createFiles(string $table, array $columns, string $auth_name, bool $force = false, string $path = ''): void
    {
        $path = $this->getPath(config_path('/'), $path);

        $file_name = 'auth.php';
        $file_path = $this->getFullFilePath($path, $file_name);

        $generator = $this->getGenerator($table, $columns, $auth_name);

        $replacements = [
            [
                'search' => "'guards' => [\n",
                'keep_search' => true,
                'content' => $generator->renderGuards() . "\n",
            ],
            [
                'search' => "'providers' => [\n",
                'keep_search' => true,
                'content' => $generator->renderProviders() . "\n",
            ],
            [
                'search' => "'passwords' => [\n",
                'keep_search' => true,
                'content' => $generator->renderPasswords() . "\n",
            ],
            [
                'search' => "'passport_guards' => [\n",
                'keep_search' => true,
                'content' => $generator->renderPassportGuards(),
            ],
        ];

        if ($generator->shouldRenderDefaultGuard()) {
            $replacements[] = [
                'search' => "'guard' => env('AUTH_GUARD', 'web_admin'),\n",
                'keep_search' => false,
                'content' => $generator->renderDefaultGuard(),
            ];

            $replacements[] = [
                'search' => "'guard' => env('AUTH_GUARD', 'web'),\n",
                'keep_search' => false,
                'content' => $generator->renderDefaultGuard(),
            ];

            $replacements[] = [
                'search' => "'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),\n",
                'keep_search' => false,
                'content' => $generator->renderDefaultPasswords(),
            ];
        }

        if ($this->appendContent($file_path, $replacements)) {
            $this->info("$table auth config created!");
        }
    }
}
