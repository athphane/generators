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
     * Get the attributes rules
     */
    protected function getRules(string $attribute): array
    {
        return $this->rules[$attribute] ?? [];
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
    protected function getAttributeType(string $attribute): ?string
    {
        $rules = $this->getRules($attribute);

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

        foreach ($rules as $rule) {
            if (Str::startsWith($rule, 'exists:')) {
                return 'foreign';
            } elseif (Str::startsWith($rule, 'in:')) {
                return 'enum';
            }
        }

        return null;
    }

    /**
     * Get an attributes rule value
     */
    public function getAttributeRuleValue(string $attribute, string $rule_name)
    {
        $rules = $this->getRules($attribute);

        foreach ($rules as $rule) {
            if (Str::startsWith($rule, $rule_name . ':')) {
                return Str::after($rule, $rule_name . ':');
            }
        }

        return null;
    }

    /**
     * Get model class from table name
     */
    public function getModelClassFromTableName(string $table): ?string
    {
        return Str::of($table)
                ->singular()
                ->studly()
                ->toString();
    }

    /**
     * Get the foreign key model
     */
    public function getAttributeForeingKeyModelClass(string $attribute): ?string
    {
        $table = $this->getAttributeForeingKeyTable($attribute);

        if ($table) {
            return $this->getModelClassFromTableName($table);
        }

        return null;
    }

    /**
     * Get the foreign key table
     */
    public function getAttributeForeingKeyTable(string $attribute): ?string
    {
        $value = $this->getAttributeRuleValue($attribute, 'exists');

        return $value ? Str::before($value, ',') : null;
    }

    /**
     * Get the foreign key name
     */
    public function getAttributeForeingKeyName(string $attribute): ?string
    {
        $value = $this->getAttributeRuleValue($attribute, 'exists');

        return $value ? Str::after($value, ',') : null;
    }

    /**
     * Get the min value for the attribute
     */
    public function getAttributeMin(string $attribute): ?int
    {
        $value = $this->getAttributeRuleValue($attribute, 'min');

        return $value ? (int) $value : null;
    }

    /**
     * Get the enum values
     */
    public function getAttributeEnumValues(string $attribute): ?array
    {
        $value = $this->getAttributeRuleValue($attribute, 'in');

        return $value ? explode(',', $value) : null;
    }

    /**
     * Get the max value for the attribute
     */
    public function getAttributeMax(string $attribute): ?int
    {
        $value = $this->getAttributeRuleValue($attribute, 'max');

        return $value ? (int) $value : null;
    }

    /**
     * Check if an attribute is required
     */
    protected function isRequired(string $attribute): bool
    {
        $rules = $this->getRules($attribute);

        return in_array('required', $rules);
    }
}
