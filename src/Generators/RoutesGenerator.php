<?php

namespace Javaabu\Generators\Generators;

class RoutesGenerator extends BaseGenerator
{
    /**
     * Render the policy
     */
    public function render(): string
    {
        $stub = 'generators::routes/_admin' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '') . '.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $this->getTable());
    }
}
