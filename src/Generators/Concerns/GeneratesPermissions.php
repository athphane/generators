<?php

namespace Javaabu\Generators\Generators\Concerns;

trait GeneratesPermissions
{
    protected function getPermissionsStub(): string
    {
        return property_exists($this, 'permissions_stub') ? $this->permissions_stub : '';
    }

    protected function getAdditionalPermissionsStub(): string
    {
        return property_exists($this, 'additional_permissions_stub') ? $this->additional_permissions_stub : '';
    }

    protected function renderAdditionalPermissions(): string
    {
        if ($stub = $this->getAdditionalPermissionsStub()) {

            $renderer = $this->getRenderer();

            return $renderer->replaceStubNames($stub, $this->getTable());
        }

        return '';
    }

    public function renderPermissions(): string
    {
        $stub = $this->getPermissionsStub();

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        $additional_permissions = $this->renderAdditionalPermissions();

        return $renderer->appendMultipleContent([
            [
                'search' => "// additional permissions\n",
                'keep_search' => false,
                'content' => $additional_permissions,
            ],
        ], $template);
    }
}
