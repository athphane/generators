<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\FieldTypes\StringField;
use Javaabu\Generators\Support\StubRenderer;
use Javaabu\Generators\Support\TableProperties;

abstract class BaseGenerator
{
    protected array $fields;
    protected string $table;
    protected string $key_name;
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

        $this->key_name = $table_properties->getKeyName();
        $this->fields = $table_properties->getFields();
        $this->soft_deletes = $table_properties->hasSoftDeletes();

        $this->renderer = app()->make(StubRenderer::class);
    }


    public function getField(string $column): ?Field
    {
        return $this->fields[$column] ?? null;
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

    /**
     * Get the key name
     */
    public function getKeyName(): string
    {
        return $this->key_name;
    }

    /**
     * Get the name field
     */
    public function getNameField(): string
    {
        // check if any reserved names exists
        $candidate_name_fields = ['name', 'title'];

        foreach ($candidate_name_fields as $column) {
            if ($this->getField($column) instanceof StringField) {
                return $column;
            }
        }

        // look for the first string field
        $fields = $this->getFields();

        foreach ($fields as $column => $field) {
            if ($field instanceof StringField) {
                return $column;
            }
        }

        // default to the key name
        return $this->getKeyName();
    }
}
