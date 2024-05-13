<?php

namespace Javaabu\Generators\Generators\Concerns;

use Illuminate\Support\Str;

trait GeneratesAuthController
{
    public function getControllerName(): string
    {
        return Str::between(class_basename($this), 'Auth', 'Generator');
    }

    public function getControllerPath(): string
    {
        return 'Http/Controllers/' . $this->getNamespace() . '/Auth';
    }

    protected function renderAuthControllerFromStub(string $stub): string
    {
        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        return $renderer->replaceNames($this->getAuthName(), $template, 'AuthName');
    }
}
