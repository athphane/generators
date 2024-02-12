<?php

namespace Javaabu\Generators\Generators;

use Illuminate\Support\Str;
use Javaabu\Generators\FieldTypes\BooleanField;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\Support\StringCaser;

class ControllerGenerator extends BaseGenerator
{
    /**
     * Render the controller
     */
    public function render(): string
    {
        $stub = 'generators::Controllers/Model' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '' )  . 'Controller.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        $orderbys = '';
        $booleans = [];
        $foreign_keys = [];

        $order_columns = [
            $this->getKeyName(),
            'created_at',
            'updated_at',
        ];

        foreach ($order_columns as $column) {
            $orderbys .= $this->renderOrderBy($column);
        }

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($this->getFields() as $column => $field) {
            if ($field->isSortable()) {
                $orderbys .= $this->renderOrderBy($column);
            }

            if ($field instanceof BooleanField) {
                $booleans[] = $this->renderBoolean($column, $field);
            } elseif ($field instanceof ForeignKeyField) {
                $foreign_keys[] = $this->renderForeignKey($column, $field);
            }
        }

        $template = $renderer->appendMultipleContent([
            [
                'search' => "static::\$orderbys = [\n",
                'keep_search' => true,
                'content' => $orderbys,
            ],
            [
                'search' => '{{keyName}}',
                'keep_search' => false,
                'content' => $this->getKeyName(),
            ],
            [
                'search' => $renderer->addIndentation("// booleans\n", 2),
                'keep_search' => false,
                'content' => $booleans ? "\n" . implode("\n", $booleans) : '',
            ],
            [
                'search' => $renderer->addIndentation("// foreign keys\n", 2),
                'keep_search' => false,
                'content' => $foreign_keys ? "\n" . implode("\n", $foreign_keys) : '',
            ],
            [
                'search' => '{{appendSpaces}}',
                'keep_search' => false,
                'content' => Str::repeat(' ', (Str::length(StringCaser::pluralSnake($this->getTable())) * 2) + 2),
            ],
        ], $template);

        return $template;
    }

    /**
     * Render a boolean
     */
    public function renderBoolean(string $column, BooleanField $field): string
    {
        $stub = 'generators::Controllers/_controllerBoolean.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        $template = $renderer->appendMultipleContent([
            [
                'search' => '{{inputName}}',
                'keep_search' => false,
                'content' => $field->getInputName(),
            ],
            [
                'search' => '{{column}}',
                'keep_search' => false,
                'content' => $column,
            ],
        ], $template);

        return $template;
    }

    /**
     * Render a foreign key
     */
    public function renderForeignKey(string $column, ForeignKeyField $field): string
    {
        $stub = 'generators::Controllers/_controllerForeignKey.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $field->getRelatedTable());
        $template = $renderer->replaceNames($this->getTable(), $template, 'Model');

        $template = $renderer->appendMultipleContent([
            [
                'search' => '{{attribute}}',
                'keep_search' => false,
                'content' => $field->getInputName(),
            ],
        ], $template);

        return $template;
    }

    /**
     * Render a foreign key
     */
    public function renderOrderBy(string $column): string
    {
        $stub = 'generators::Controllers/_orderBy.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $column);
    }
}
