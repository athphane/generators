<?php

namespace Dash8x\Generators\Commands;

use Dash8x\Generators\Commands\Traits\HasGeneratorOptions;
use Dash8x\Generators\Commands\Traits\CanReplaceKeywords;


class GeneratorsControllerInstallCommand extends InstallFilesCommand
{
    use HasGeneratorOptions;
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Controller';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getFiles()
    {
        $name = $this->getPluralClassNameInput();
        $controller_stub = $this->softDeletes() ? 'ModelSoftDeletesController' : 'ModelController';

        return [
            'model' => [
                'path' => '/app/Http/Controllers/Admin/' . $name .'Controller.php',
                'stub' => __DIR__ . '/../stubs/Controllers/'.$controller_stub.'.stub',
            ],
        ];
    }
}
