<?php

namespace Javaabu\Generators\Commands;

use Javaabu\Generators\Commands\Traits\CanReplaceKeywords;


class GeneratorsRequestInstallCommand extends InstallFilesCommand
{
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Request';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getFiles()
    {
        $name = $this->getPluralClassNameInput();

        return [
            'model' => [
                'path' => '/app/Http/Requests/' . $name .'Request.php',
                'stub' => __DIR__ . '/../stubs/Requests/ModelRequest.stub',
            ],
        ];
    }
}
