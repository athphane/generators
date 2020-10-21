<?php

namespace Javaabu\Generators\Commands;

use Javaabu\Generators\Commands\Traits\HasGeneratorOptions;
use Javaabu\Generators\Commands\Traits\CanReplaceKeywords;
use Symfony\Component\Console\Input\InputOption;


class GeneratorsTestsInstallCommand extends InstallFilesCommand
{
    use HasGeneratorOptions;
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install tests';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getFiles()
    {
        $name = $this->getPluralClassNameInput();

        $files = [];

        if ($this->option('controller')) {
            $test_stub = $this->softDeletes() ? 'ModelSoftDeletesControllerTest' : 'ModelControllerTest';

            $files['controller'] = [
                'path' => '/tests/Feature/Controllers/Admin/' . $name .'ControllerTest.php',
                'stub' => __DIR__ . '/../stubs/tests/'.$test_stub.'.stub',
            ];
        }

        return $files;
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
            ['controller', null, InputOption::VALUE_NONE, 'Include controller'],
        ];
    }
}
