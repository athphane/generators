<?php

namespace Javaabu\Generators\Generators\Auth\Controllers;

use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\Generators\Concerns\GeneratesAuthController;
use Javaabu\Generators\Generators\Concerns\GeneratesRequest;

class AuthRegisterControllerGenerator extends BaseAuthControllerGenerator
{
    use GeneratesRequest;
    use GeneratesAuthController;

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

    /**
     * Render the views
     */
    public function render(): string
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
}
