<?php

namespace Javaabu\Generators\Generators\Auth\Controllers;

use Javaabu\Generators\Generators\Concerns\GeneratesAuthController;

class AuthHomeControllerGenerator extends BaseAuthControllerGenerator
{
    use GeneratesAuthController;

    public function getControllerPath(): string
    {
        return 'Http/Controllers/' . $this->getNamespace();
    }

    public function getControllerName(): string
    {
        return 'HomeController';
    }

    /**
     * Render the views
     */
    public function render(): string
    {

        return $this->renderAuthControllerFromStub('generators::Controllers/Auth/HomeController.stub');
    }
}
