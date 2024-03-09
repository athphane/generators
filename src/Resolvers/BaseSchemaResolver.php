<?php

namespace Javaabu\Generators\Resolvers;

use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\FieldTypes\DateTimeField;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\Support\TableProperties;
use stdClass;

abstract class BaseSchemaResolver implements SchemaResolverInterface
{
    private string $table;

    private array $columns;

    public function __construct(string $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    public function resolve(): TableProperties
    {
        $tableColumns = $this->getColumnsDefinitionsFromTable();

        $skip_columns = config('generators.skip_columns');

        $table_fields = [];
        $soft_deletes = false;
        $found_updated_at = false;
        $found_created_at = false;
        $key_name = '';

        foreach ($tableColumns as $column) {
            $field = $this->getField($column);
            $field_type = $this->resolveColumnFieldType($column);

            if ($field == 'deleted_at' && ($field_type instanceof DateTimeField)) {
                $soft_deletes = true;
            }

            if ($field == 'updated_at' && ($field_type instanceof DateTimeField)) {
                $found_updated_at = true;
            }

            if ($field == 'created_at' && ($field_type instanceof DateTimeField)) {
                $found_created_at = true;
            }

            // If specific columns where supplied only process those...
            if (! empty($this->columns()) && ! in_array($field, $this->columns())) {
                continue;
            }

            // If column should be skipped
            if (in_array($field, $skip_columns)) {
                continue;
            }

            // We do not need a rule for auto increments
            if ($this->isAutoIncrement($column)) {
                $key_name = $field;
                continue;
            }

            if ($field_type) {
                $table_fields[$field] = $field_type;
            }
        }

        return new TableProperties($table_fields, $key_name, $soft_deletes, $found_updated_at && $found_created_at);
    }

    protected function table()
    {
        return $this->table;
    }

    protected function columns()
    {
        return $this->columns;
    }

    abstract protected function isAutoIncrement($column): bool;

    abstract protected function getField($column): string;

    abstract protected function getColumnsDefinitionsFromTable();

    abstract protected function resolveColumnFieldType(stdClass $column): ?Field;
}
