<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;

class ApiGenerator extends BaseGenerator
{
    /**
     * Render the controller
     */
    public function render(): string
    {
        $stub = 'generators::Controllers/ModelApiController.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        $relations = [];

        $filters = [
            $this->getKeyName(),
        ];

        $sorts = [
            $this->getKeyName(),
        ];

        if ($this->hasTimestamps()) {
            $sorts[] = 'created_at';
            $sorts[] = 'updated_at';
        }

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($this->getFields() as $column => $field) {
            if ($field->isSortable()) {
                $sorts[] = $column;
            }

            if ($field->isSearchable()) {
                $filters[] = $column;
            }

            if ($field instanceof ForeignKeyField) {
                $relations[] = $field->getRelationName();
            }
        }

        $template = $renderer->appendMultipleContent([
            [
                'search' => '{{tableName}}',
                'keep_search' => false,
                'content' => $this->getTable(),
            ],
            [
                'search' => '{{defaultSort}}',
                'keep_search' => false,
                'content' => $this->hasTimestamps() ? 'created_at' : $this->getKeyName(),
            ],
            [
                'search' => $renderer->addIndentation("// allowed sorts\n", 3),
                'keep_search' => false,
                'content' => $this->renderStringList($sorts),
            ],

            [
                'search' => $renderer->addIndentation("// allowed includes\n", 3),
                'keep_search' => false,
                'content' => $this->renderStringList($relations),
            ],
            [
                'search' => $renderer->addIndentation("// allowed filters\n", 3),
                'keep_search' => false,
                'content' => $this->renderStringList($filters),
            ],
        ], $template);

        return $template;
    }

    /**
     * Render the policy
     */
    public function renderRoutes(): string
    {
        $stub = 'generators::routes/_api.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $this->getTable());
    }

    /**
     * Render a string list
     */
    public function renderStringList(array $list, int $indent = 3): string
    {
        $output = '';

        $renderer = $this->getRenderer();

        foreach ($list as $item) {
            $output .= $renderer->addIndentation("'$item',\n", $indent);
        }

        return $output;
    }
}
