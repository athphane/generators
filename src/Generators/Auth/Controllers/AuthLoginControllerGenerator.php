<?php

namespace Javaabu\Generators\Generators\Auth\Controllers;

use Javaabu\Generators\Generators\Concerns\GeneratesAuthController;

class AuthLoginControllerGenerator extends BaseAuthControllerGenerator
{
    use GeneratesAuthController;

    /**
     * Render the views
     */
    public function render(): string
    {

        return $this->renderAuthControllerFromStub('generators::Controllers/Auth/LoginController.stub');
    }
}
