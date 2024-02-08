<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\Support\StubRenderer;
use Javaabu\Generators\Support\TableProperties;

abstract class BaseGenerator
{
    protected array $fields;
    protected string $table;
    protected array $columns;
    protected bool $soft_deletes;
    protected StubRenderer $renderer;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;

        /** @var TableProperties $table_properties */
        $table_properties = app()->make(SchemaResolverInterface::class, compact('table', 'columns'))->resolve();

        $this->fields = $table_properties->getFields();
        $this->soft_deletes = $table_properties->hasSoftDeletes();

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

    /**
     * @return bool
     */
    public function hasSoftDeletes(): bool
    {
        return $this->soft_deletes;
    }

    /**
     * Get the fillable attributes
     */
    public function getFillableAttributes(): array
    {
        $fillable = [];

        $fields = $this->getFields();

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($fields as $column => $field) {
            if ($field->isFillable()) {
                $fillable[] = $column;
            }
        }

        return $fillable;
    }

    /**
     * Get the searchable attributes
     */
    public function getSearchableAttributes(): array
    {
        $fillable = [];

        $fields = $this->getFields();

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($fields as $column => $field) {
            if ($field->isSearchable()) {
                $fillable[] = $column;
            }
        }

        return $fillable;
    }

    /**
     * Get the foreign keys
     */
    public function getForeignKeyAttributes(): array
    {
        $fillable = [];

        $fields = $this->getFields();

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($fields as $column => $field) {
            if ($field instanceof ForeignKeyField) {
                $fillable[] = $column;
            }
        }

        return $fillable;
    }
}
