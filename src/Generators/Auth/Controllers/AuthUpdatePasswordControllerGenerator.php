<?php

namespace Javaabu\Generators\Generators\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\BaseAuthGenerator;
use Javaabu\Generators\Generators\Concerns\GeneratesAuthController;

class AuthUpdatePasswordControllerGenerator extends BaseAuthGenerator
{
    use GeneratesAuthController;

    /**
     * Render the views
     */
    public function render(): string
    {

        return $this->renderAuthControllerFromStub('generators::Controllers/Auth/UpdatePasswordController.stub');
    }
}
