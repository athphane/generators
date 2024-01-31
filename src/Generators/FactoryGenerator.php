<?php

namespace Javaabu\Generators\Generators;

use Faker\Generator;
use Illuminate\Support\Str;

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

        if ($field->isNullable()) {
            $statement .= '->optional()';
        }

        if ($field->isUnique()) {
            $statement .= '->unique()';
        }

        $faker_method = $this->getFakerMethodFromColumnName($column);

        if ($faker_method) {
            $statement .= '->' . $faker_method . '()';
        } else {
            $statement .= '->' . $field->generateFactoryStatement();
        }

        return $statement;
    }
}
