<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\FieldTypes\Field;

abstract class BaseGenerator
{
    protected array $fields;

    protected string $table;

    protected array $columns;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->fields = app()->make(SchemaResolverInterface::class, compact('table', 'columns'))->resolve();
    }


    public function getField(string $column): Field
    {
        return $this->fields[$column];
    }

    public function isNullable(string $column): bool
    {
        return $this->getField($column)->isNullable();
    }

    public function hasDefault(string $column): bool
    {
        return $this->getField($column)->hasDefault();
    }
}
