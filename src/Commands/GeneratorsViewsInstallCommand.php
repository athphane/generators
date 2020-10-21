<?php

namespace Javaabu\Generators\Commands;

use Javaabu\Generators\Commands\Traits\HasGeneratorOptions;
use Javaabu\Generators\Commands\Traits\CanReplaceKeywords;
use SplFileInfo;


class GeneratorsViewsInstallCommand extends InstallAndReplaceCommand
{
    use HasGeneratorOptions;
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install generators views';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->installViews();
    }

    /**
     * Install Web Routes.
     *
     * @return bool
     */
    public function installViews()
    {
        $name = $this->getPluralSlugNameInput();

        $path = '/resources/views/admin/' . $name . '/';
        $view_stubs = $this->softDeletes() ? 'model-soft-deletes' : 'model';
        $views = __DIR__ . '/../stubs/views/'.$view_stubs;

        if($this->installFiles($path, $this->files->allFiles($views))) {
            $this->info('Copied: ' . $path);
        }

        //add model base view
        $view_stub = __DIR__ . '/../stubs/views/model.blade.stub';
        $full_view_path = base_path() . $path . $name . '.blade.php';
        $stub_file_object = new SplFileInfo($view_stub);

        if($this->putFile($full_view_path, $stub_file_object)) {
            $this->getInfoMessage($full_view_path);
        }

        return true;
    }

    /**
     * Get file extension.
     *
     * @param $file
     * @return bool
     */
    protected function getExtension($file)
    {
        return 'php';
    }
}
