<?php

namespace Javaabu\Generators\Generators\Auth;

use Illuminate\Support\Str;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\Generators\Concerns\GeneratesController;
use Javaabu\Generators\Generators\Concerns\GeneratesRequest;
use Javaabu\Generators\Support\StringCaser;

class AuthControllerGenerator extends BaseAuthGenerator
{
    use GeneratesController;
    use GeneratesRequest;

    protected string $request_stub = 'generators::Controllers/Auth/RegisterController.stub';

    /**
     * Whether to render rules for only required columns
     */
    protected function renderOnlyRequiredColumnRules(): bool
    {
        return true;
    }

    /**
     * Whether to use inline unique rules
     */
    protected function useInlineUniqueRules(): bool
    {
        return true;
    }

    /**
     * Whether to use inline required rules
     */
    protected function useInlineRequiredRules(): bool
    {
        return true;
    }

    protected function getRequestRulesBodyStub(): string
    {
        return 'generators::Controllers/Auth/_registerRulesBody.stub';
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

    public function renderRegisterAssignments(): string
    {
        $fields = $this->getFields();
        $assignments = [];
        $renderer = $this->getRenderer();

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($fields as $column => $field) {
            if ($field->isRequired()) {
                $assignments[] = $renderer->addIndentation($this->renderRegisterAssignment($column), 2);
            }
        }

        return implode("\n", $assignments);
    }

    public function renderRegisterAssignment(string $column): string
    {
        $field = $this->getField($column);

        return '$' . $this->getMorph() . '->' . $field->renderAssignment('$data[', ']') . ';';
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
            'renderRegisterController' => $auth_namespace . 'RegisterController.php',
            'renderLoginController' => $auth_namespace . 'LoginController.php',
            'renderHomeController' => $namespace . '/HomeController.php',
        ];
    }

    public function renderRegisterController(): string
    {
        $template = $this->renderRequest();

        $renderer = $this->getRenderer();

        $template = $renderer->replaceNames($this->getAuthName(), $template, 'AuthName');

        $assignments = $this->renderRegisterAssignments();

        return $renderer->appendMultipleContent([
            [
                'search' => $renderer->addIndentation("// assignments\n", 2),
                'keep_search' => false,
                'content' => $assignments ? $assignments . "\n" : '',
            ],
        ], $template);
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
