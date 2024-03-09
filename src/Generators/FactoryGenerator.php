<?php

namespace Javaabu\Generators\Generators;

use Faker\Generator;
use Illuminate\Support\Str;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\Support\StringCaser;

class FactoryGenerator extends BaseGenerator
{
    protected Generator $faker;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [])
    {
        parent::__construct($table, $columns);

        $this->faker = app(Generator::class);
    }

    /**
     * Determine fake method attribute
     */
    public function getFakerMethodFromColumnName(string $column): ?string
    {
        // don't want to use the name() method
        if ($column == 'name') {
            return null;
        }

        $method = Str::camel($column);

        try {
            if (method_exists($this->faker, $method) || $this->faker->getFormatter($method)) {
                return $method;
            }
        } catch (\InvalidArgumentException $e) {}

        return null;
    }

    /**
     * Determine fake method attribute
     */
    public function getFakerStatement(string $column): ?string
    {
        $field = $this->getField($column);

        if (! $field) {
            return null;
        }

        $statement = '$this->faker';

        if ($field->isUnique()) {
            $statement .= '->unique()';
        }

        if ($field->isNullable()) {
            $statement .= '->optional()';
        }

        $faker_method = $this->getFakerMethodFromColumnName($column);

        if ($faker_method) {
            $statement .= '->' . $faker_method . '()';
        } else {
            $statement .= '->' . $field->generateFactoryStatement();
        }

        return $statement;
    }

    /**
     * Render the factory
     */
    public function render(): string
    {
        $stub = 'generators::factories/ModelFactory.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        $definitions = '';
        $foreign_keys = [];
        $required_foreign_keys = [];

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($this->getFields() as $column => $field) {
            if ($field instanceof ForeignKeyField) {
                $foreign_keys[] = $this->renderForeignKey($column, $field);

                if ($field->isRequired()) {
                    $required_foreign_keys[$column] = $field;
                }

            } else {
                $statement = "'$column' => {$this->getFakerStatement($column)},\n";

                if ($definitions) {
                    $definitions .= $renderer->addIndentation($statement, 3);
                } else {
                    $definitions = $statement;
                }
            }
        }

        $foreign_keys = implode("\n", $foreign_keys);

        $foreign_key_search = "// foreign keys\n";
        $required_relations = $this->renderRequiredRelations($required_foreign_keys);

        $template = $renderer->appendMultipleContent([
            [
                'search' => "// definition\n",
                'keep_search' => false,
                'content' => $definitions,
            ],
            [
                'search' => "// foreign keys\n",
                'keep_search' => true,
                'content' => $required_relations ? "\n" . $required_relations : '',
            ],
            [
                'search' => $foreign_keys ? $foreign_key_search : $renderer->addIndentation($foreign_key_search, 1),
                'keep_search' => false,
                'content' => Str::replaceFirst('    ', '', $foreign_keys),
            ]
        ], $template);

        return $template;
    }

    public function getFactoryName(): string
    {
        return StringCaser::singularStudly($this->getTable()) . 'Factory';
    }

    /**
     * Render a foreign key
     */
    public function renderForeignKey(string $column, ForeignKeyField $field): string
    {
        $stub = 'generators::factories/_factoryForeignKey.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $field->getRelatedTable());
        $statement = "'$column' => ".'$this->faker->'."{$field->generateFactoryStatement()},\n";

        return $renderer->appendMultipleContent([
            [
                'search' => "// statement\n",
                'keep_search' => false,
                'content' => $statement,
            ],
            [
                'search' => "{{factoryName}}",
                'keep_search' => false,
                'content' => $this->getFactoryName(),
            ]
        ], $template);
    }

    /**
     * Render a foreign key
     */
    public function renderRequiredRelations(array $required_relations): string
    {
        if (! $required_relations) {
            return '';
        }

        $stub = 'generators::factories/_factoryRequiredRelations.stub';
        $renderer = $this->getRenderer();

        $code = '';

        $i = 0;
        $count = count($required_relations);

        /* @var ForeignKeyField $field */
        foreach ($required_relations as $column => $field) {
            $is_first = $i == 0;
            $is_last = $i == ($count - 1);

            $new_line = ! $is_last ? "\n" : '';
            $statement = '->with' . StringCaser::singularStudly($field->getRelatedTable()) . "()$new_line";

            $code .= ! $is_first ? $renderer->addIndentation($statement, 2, match_length: 'return $this') : $statement;

            $i++;
        }



        $template = $renderer->loadStub($stub);

        return $renderer->appendMultipleContent([
            [
                'search' => "\$this",
                'keep_search' => true,
                'content' => $code,
            ],
            [
                'search' => "{{factoryName}}",
                'keep_search' => false,
                'content' => $this->getFactoryName(),
            ]
        ], $template);
    }
}
