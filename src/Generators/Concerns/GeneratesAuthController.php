<?php

namespace Javaabu\Generators\Generators\Concerns;

trait GeneratesAuthController
{

    protected function renderAuthControllerFromStub(string $stub): string
    {
        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        return $renderer->replaceNames($this->getAuthName(), $template, 'AuthName');
    }
}
