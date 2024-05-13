<?php

namespace Javaabu\Generators\Generators\Auth\Controllers;

use Javaabu\Generators\Generators\Concerns\GeneratesController;

class AuthControllerGenerator extends BaseAuthControllerGenerator
{
    use GeneratesController;

    public function getControllerPath(): string
    {
        return 'Http/Controllers/Admin';
    }

    public function getControllerStub(): string
    {
        return 'generators::Controllers/Auth/AuthModelSoftDeletesController.stub';
    }

    protected function getControllerFillUpdateIndentation(): int
    {
        return 3;
    }

    protected function getAdditionalControllerEagerLoads(): array
    {
        return [
            "'media'"
        ];
    }

    protected function getAuthColumnOrderbys(): array
    {
        return [
            'name',
            'email',
        ];
    }

    protected function getAdditionalControllerOrderbys(): array
    {
        $orderbys = array_values(array_filter($this->getAuthColumnOrderbys(), [$this, 'isAuthColumn']));

        return $orderbys;
    }



    /**
     * Render the views
     */
    public function render(): string
    {
        return $this->renderController();
    }
}
