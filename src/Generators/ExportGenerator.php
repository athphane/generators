<?php

namespace Javaabu\Generators\Generators;

class ExportGenerator extends BaseGenerator
{
    /**
     * Render the policy
     */
    public function render(): string
    {
        $stub = 'generators::Exports/ModelExport.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $this->getTable());
    }
}
