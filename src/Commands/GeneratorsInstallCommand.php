<?php

namespace Dash8x\Generators\Commands;

use Dash8x\Generators\Commands\Traits\HasGeneratorOptions;
use Dash8x\Generators\Commands\Traits\CanReplaceKeywords;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Console\Input\InputOption;


class GeneratorsInstallCommand extends InstallAndReplaceCommand
{
    use HasGeneratorOptions;
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Views, Models, Controllers, etc into Laravel 5.8 project';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        if($this->option('force')) {
            $name = $this->getParsedNameInput();
            $soft_deletes = $this->softDeletes();

            if(!$this->option('model')) {
                Artisan::call('generators:model', [
                    'name' => $name,
                    '--force' => true,
                    '--soft_deletes' => $soft_deletes,
                ]);

                $this->installMigration();
            }

            if(!$this->option('policy')) {
                Artisan::call('generators:policy', [
                    'name' => $name,
                    '--force' => true,
                    '--soft_deletes' => $soft_deletes,
                ]);
            }

            if(!$this->option('request')) {
                Artisan::call('generators:request', [
                    'name' => $name,
                    '--force' => true
                ]);
            }

            if(!$this->option('controller')) {
                Artisan::call('generators:controller', [
                    'name' => $name,
                    '--force' => true,
                    '--soft_deletes' => $soft_deletes,
                ]);
            }

            if(!$this->option('views')) {
                Artisan::call('generators:views', [
                    'name' => $name,
                    '--force' => true,
                    '--soft_deletes' => $soft_deletes,
                ]);
            }

            if(!$this->option('routes')) {
                Artisan::call('generators:routes', [
                    'name' => $name,
                    '--force' => true,
                    '--soft_deletes' => $soft_deletes,
                ]);
            }

            if(!$this->option('tests')) {
                Artisan::call('generators:tests', [
                    'name' => $name,
                    '--controller' => true,
                    '--force' => true,
                    '--soft_deletes' => $soft_deletes,
                ]);
            }

            /*if(!$this->option('lang')) {
                Artisan::call('generators:lang', [
                    'name' => $name,
                    '--force' => true
                ]);
            }*/

            $this->info(ucfirst($name) . ' files successfully installed.');

            return true;
        }

        $this->info('Use `-f` flag first.');

        return true;
    }

    /**
     * Install Migration.
     *
     * @return bool
     */
    public function installMigration()
    {
        $name = $this->getParsedNameInput();

        $migrationDir = base_path() . '/database/migrations/';
        $migrationName = 'create_' . Str::plural(Str::snake($name)) .'_table.php';
        $stub_name = $this->softDeletes() ? 'migration-soft-deletes' : 'migration';
        $migrationStub = new SplFileInfo(__DIR__ . '/../stubs/Model/'.$stub_name.'.stub');

        $files = $this->files->allFiles($migrationDir);

        foreach ($files as $file) {
            if(Str::contains($file->getFilename(), $migrationName)) {
                $this->putFile($file->getPathname(), $migrationStub);

                return true;
            }
        }

        $path = $migrationDir . date('Y_m_d_His') . '_' . $migrationName;
        $this->putFile($path, $migrationStub);

        return true;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
            ['soft_deletes', 's', InputOption::VALUE_NONE, 'Enable soft deletes'],
            ['policy', null, InputOption::VALUE_NONE, 'Exclude policy'],
            ['controller', null, InputOption::VALUE_NONE, 'Exclude controller'],
            ['request', null, InputOption::VALUE_NONE, 'Exclude request'],
            ['model', null, InputOption::VALUE_NONE, 'Exclude model and migration'],
            ['views', null, InputOption::VALUE_NONE, 'Exclude views'],
            ['routes', null, InputOption::VALUE_NONE, 'Exclude routes'],
            ['tests', null, InputOption::VALUE_NONE, 'Exclude test files'],
            ['lang', null, InputOption::VALUE_NONE, 'Exclude language files'],
        ];
    }
}
