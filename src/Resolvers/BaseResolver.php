<?php

namespace Javaabu\Generators\Resolvers;

use Illuminate\Support\Str;
use LaracraftTech\LaravelSchemaRules\Contracts\SchemaRulesResolverInterface;

abstract class BaseResolver
{
    protected array $rules;

    protected string $table;

    protected array $columns;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->rules = app()->make(SchemaRulesResolverInterface::class, compact('table', 'columns'))->generate();
    }

    /**
     * Determine the type from the attribute and rules
     *
     * Supported types:
     * - decimal
     * - integer
     * - text
     * - string
     * - boolean
     * - array
     * - date
     * - foreign
     * - enum
     */
    protected function getAttributeType(string $attribute, array $rules): string
    {
        if (in_array('numeric', $rules)) {
            return 'decimal';
        }

        if (in_array('integer', $rules)) {
            return 'integer';
        }

        if (in_array('string', $rules)) {
            foreach ($rules as $rule) {
                if (Str::startsWith($rule, 'max:')) {
                    return 'string';
                }
            }

            return 'text';
        }

        if (in_array('boolean', $rules)) {
            return 'boolean';
        }

        if (in_array('json', $rules)) {
            return 'array';
        }

        if (in_array('date', $rules)) {
            return 'date';
        }

        if (in_array('exists', $rules)) {
            return 'foreign';
        }

        foreach ($rules as $rule) {
            if (Str::startsWith($rule, 'in:')) {
                return 'enum';
            }
        }


    }

    /**
     * Check if an attribute is required
     */
    protected function isRequired(string $attribute, array $rules): bool
    {
        return in_array('required', $rules);
    }
}
