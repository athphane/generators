<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\Support\StubRenderer;

abstract class BaseGenerator
{
    protected array $fields;
    protected string $table;
    protected array $columns;
    protected StubRenderer $renderer;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->fields = app()->make(SchemaResolverInterface::class, compact('table', 'columns'))->resolve();
        $this->renderer = app()->make(StubRenderer::class);
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

    public function getRenderer(): StubRenderer
    {
        return $this->renderer;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getTable(): string
    {
        return $this->table;
    }
}
