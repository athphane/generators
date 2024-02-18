<?php

namespace Javaabu\Generators\FieldTypes;

use Illuminate\Support\Str;
use Javaabu\Generators\Support\StringCaser;

class ForeignKeyField extends Field
{
    protected string $related_table;
    protected string $related_key_name;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        string $related_table,
        string $related_key_name = 'id',
        bool $nullable = false,
        $default = null,
        bool $unique = false
    )
    {
        parent::__construct(
            $name,
            $nullable,
            default: $default,
            unique: $unique
        );

        $this->related_table = $related_table;
        $this->related_key_name = $related_key_name;
    }

    public function getRelatedTable(): string
    {
        return $this->related_table;
    }

    public function getRelatedKeyName(): string
    {
        return $this->related_key_name;
    }

    public function getRelatedModelClass(): string
    {
        return StringCaser::singularStudly($this->getRelatedTable());
    }

    public function getRelatedModelMorph(): string
    {
        return StringCaser::singularSnake($this->getRelatedTable());
    }

    public function getInputName(): string
    {
        $name = $this->getName();

        if (Str::endsWith($name, '_id') && ($new_name = Str::beforeLast($name, '_id'))) {
            return $new_name;
        }

        return $name;
    }

    public function generateFactoryStatement(): string
    {
        $model_class = $this->getRelatedModelClass();
        $key_name = $this->getRelatedKeyName();

        return 'passThrough(random_id_or_generate(\\App\\Models\\'.$model_class.'::class, \'' . $key_name. '\', generate: true))';
    }

    public function generateValidationRules(): array
    {
        return ['exists:' . $this->getRelatedTable() . ',' . $this->getRelatedKeyName()];
    }

    public function isFillable(): bool
    {
        return false;
    }

    public function generateCast(): ?string
    {
        return null;
    }

    public function generateRelationStatement(): string
    {
        $statement = 'belongsTo(' . $this->getRelatedModelClass() . '::class';

        $related_key = $this->getRelatedKeyName();

        if ((! Str::endsWith($this->getName(), '_id')) || $related_key != 'id') {
            $statement .= ', \'' . $this->getName() . '\'';

            if ($related_key != 'id') {
                $statement .= ', \'' . $related_key . '\'';
            }
        }

        $statement .= ')';

        return $statement;
    }

    public function generateWrongValue(): string
    {
        return '-1';
    }

    public function generateCorrectValue(): string
    {
        return '$old_' . $this->getInputName() . '->' . $this->getRelatedKeyName();
    }

    public function generateDifferentCorrectValue(): string
    {
        return '$new_' . $this->getInputName() . '->' . $this->getRelatedKeyName();
    }

    public function generateTestFactoryStatement(string $prefix): string
    {
        return '$' . $prefix . $this->getInputName() . ' = $this->getFactory(' . $this->getRelatedModelClass() . '::class)->create();';
    }

    public function getComponentName(): string
    {
        return 'select';
    }

    public function getComponentAttributes(): array
    {
        return [
            ':options' => '\\App\\Models\\' . $this->getRelatedModelClass() . '::query()',
        ];
    }
}
