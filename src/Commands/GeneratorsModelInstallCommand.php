<?php

namespace Dash8x\Generators\Commands;

use Dash8x\Generators\Commands\Traits\HasGeneratorOptions;


class GeneratorsModelInstallCommand extends InstallFilesAndAppendContentCommand
{
    use HasGeneratorOptions;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Model';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getFiles()
    {
        $name = $this->getSingularClassNameInput();
        $model_stub = $this->softDeletes() ? 'ModelSoftDeletes' : 'Model';

        return [
            'model' => [
                'path' => '/app/' . $name .'.php',
                'stub' => __DIR__ . '/../stubs/Model/'.$model_stub.'.stub',
            ],
            'factory' => [
                'path' => '/database/factories/' . $name .'Factory.php',
                'stub' => __DIR__ . '/../stubs/factories/ModelFactory.stub',
            ],
        ];
    }

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getSettings()
    {
        return [
            'register_morph_map' => [
                'path' => '/app/Providers/AppServiceProvider.php',
                'search' => 'Relation::morphMap([',//."\n",
                'stub' => __DIR__ . '/../stubs/Providers/register-morph-map.stub',
                'prefix' => false,
            ],

            'register_subject_type' => [
                'path' => '/app/Helpers/ActivityLog/Enums/SubjectTypes.php',
                'search' => 'protected static $types = [',//."\n",
                'stub' => __DIR__ . '/../stubs/Helpers/register-subject-type.stub',
                'prefix' => false,
            ],
        ];
    }
}
