<?php

namespace Javaabu\Generators\Generators\Auth;

use Javaabu\Generators\Generators\Concerns\GeneratesController;
use Javaabu\Generators\Support\StringCaser;

class AuthControllerGenerator extends BaseAuthGenerator
{
    use GeneratesController;

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

    public function controllersToRender(): array
    {
        $namespace = $this->getNamespace();
        $auth_namespace = $namespace . '/Auth/';

        return [
            'renderController' => 'Admin/' . StringCaser::pluralStudly($this->getTable()) . 'Controller.php',
            'renderConfirmPasswordController' => $auth_namespace . 'ConfirmPasswordController.php',
            'renderForgotPasswordController' => $auth_namespace . 'ForgotPasswordController.php',
            'renderResetPasswordController' => $auth_namespace . 'ResetPasswordController.php',
            'renderUpdatePasswordController' => $auth_namespace . 'UpdatePasswordController.php',
            'renderVerificationController' => $auth_namespace . 'VerificationController.php',
            'renderLoginController' => $auth_namespace . 'LoginController.php',
            'renderHomeController' => $namespace . '/HomeController.php',
        ];
    }

    public function renderHomeController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/HomeController.stub');
    }

    public function renderLoginController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/LoginController.stub');
    }

    public function renderVerificationController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/VerificationController.stub');
    }

    public function renderUpdatePasswordController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/UpdatePasswordController.stub');
    }

    public function renderResetPasswordController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/ResetPasswordController.stub');
    }

    public function renderConfirmPasswordController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/ConfirmPasswordController.stub');
    }

    public function renderForgotPasswordController(): string
    {
        return $this->renderControllerFromStub('generators::Controllers/Auth/ForgotPasswordController.stub');
    }

    protected function renderControllerFromStub(string $stub): string
    {
        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        return $renderer->replaceNames($this->getAuthName(), $template, 'AuthName');
    }



    /**
     * Render the views
     */
    public function render(): string
    {

        $output = '';

        $views = $this->controllersToRender();

        foreach ($views as $method => $file_name) {
            $output .= "// $file_name\n";
            $output .= $this->{$method}();
        }

        return $output;
    }
}
