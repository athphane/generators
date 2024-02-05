<?php

namespace Javaabu\Generators\Generators;

class PermissionsGenerator extends BaseGenerator
{
    /**
     * Render the policy
     */
    public function render(): string
    {
        $stub = 'generators::seeders/_permissions' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '') . '.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $this->getTable());
    }
}
