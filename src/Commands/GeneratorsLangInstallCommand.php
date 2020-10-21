<?php

namespace Javaabu\Generators\Commands;

use Hesto\Core\Traits\CanReplaceKeywords;


class GeneratorsLangInstallCommand extends AppendContentOnceCommand
{
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Translations';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getSettings()
    {
        return [
            'dv' => [
                'path' => '/resources/lang/dv.json',
                'search' => '{',
                'stub' => __DIR__ . '/../stubs/lang/dv.stub',
                'prefix' => false,
            ],
        ];
    }
}
