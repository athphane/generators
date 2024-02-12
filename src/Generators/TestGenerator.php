<?php

namespace Javaabu\Generators\Generators;

use Illuminate\Support\Str;
use Javaabu\Generators\FieldTypes\BooleanField;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\Support\StringCaser;

class TestGenerator extends BaseGenerator
{
    /**
     * Render the controller
     */
    public function render(): string
    {
        $stub = 'generators::tests/Model' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '' )  . 'ControllerTest.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        $orderbys = '';
        $booleans = [];
        $foreign_keys = [];


        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($this->getFields() as $column => $field) {

        }

        $template = $renderer->appendMultipleContent([
            [
                'search' => "// errors\n",
                'keep_search' => false,
                'content' => $this->renderErrors(),
            ],
            [
                'search' => "// correct inputs\n",
                'keep_search' => false,
                'content' => $this->renderCorrectInputs(),
            ],
            [
                'search' => "// correct db values\n",
                'keep_search' => false,
                'content' => $this->renderCorrectDbValues(),
            ],
            [
                'search' => "// different correct inputs\n",
                'keep_search' => false,
                'content' => $this->renderDifferentCorrectInputs(),
            ],
            [
                'search' => "// different correct db values\n",
                'keep_search' => false,
                'content' => $this->renderDifferentCorrectDbValues(),
            ],
            [
                'search' => "// wrong inputs\n",
                'keep_search' => false,
                'content' => $this->renderWrongInputs(),
            ],
            [
                'search' => "// wrong db values\n",
                'keep_search' => false,
                'content' => $this->renderWrongDbValues(),
            ],
            [
                'search' => '{{keyName}}',
                'keep_search' => false,
                'content' => $this->getKeyName(),
            ],
            [
                'search' => '{{tableName}}',
                'keep_search' => false,
                'content' => $this->getTable(),
            ],
            [
                'search' => '{{nameField}}',
                'keep_search' => false,
                'content' => $this->getNameField(),
            ],
        ], $template);

        return $template;
    }

    public function renderErrors(): string
    {
        $errors = '';
        $fields = $this->getFields();
        $renderer = $this->getRenderer();

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($fields as $column => $field) {
            $errors .= $renderer->addIndentation("'" . $field->getInputName() . "',\n", 4);
        }

        return $errors;
    }

    protected function renderValues(string $key_callback, string $value_callback, int $tabs = 0): string
    {
        $values = '';
        $fields = $this->getFields();
        $renderer = $this->getRenderer();

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($fields as $column => $field) {
            $value = $field->{$value_callback}();
            $key = $field->{$key_callback}();

            $values .= $renderer->addIndentation("'$key' => $value,\n", $tabs);
        }

        return $values;
    }

    public function renderWrongInputs(): string
    {
        return $this->renderValues('getInputName', 'generateWrongValue', 3);
    }

    public function renderWrongDbValues(): string
    {
        return $this->renderValues('getName', 'generateWrongValue', 3);
    }

    public function renderCorrectInputs(): string
    {
        return $this->renderValues('getInputName', 'generateCorrectValue', 3);
    }

    public function renderCorrectDbValues(): string
    {
        return $this->renderValues('getName', 'generateCorrectValue', 3);
    }

    public function renderDifferentCorrectInputs(): string
    {
        return $this->renderValues('getInputName', 'generateDifferentCorrectValue', 3);
    }

    public function renderDifferentCorrectDbValues(): string
    {
        return $this->renderValues('getName', 'generateDifferentCorrectValue', 3);
    }

}
