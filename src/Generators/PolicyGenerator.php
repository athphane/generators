<?php

namespace Javaabu\Generators\Generators;

class PolicyGenerator extends BaseGenerator
{
    /**
     * Render the policy
     */
    public function render(): string
    {
        $stub = 'generators::Policies/Model' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '') . 'Policy.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $this->getTable());
    }
}
