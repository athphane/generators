<?php

namespace Javaabu\Generators\FieldTypes;

use Illuminate\Support\Str;

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
        $default = null
    )
    {
        parent::__construct($name, $nullable, default: $default);

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
        return Str::of($this->getRelatedTable())
            ->singular()
            ->studly()
            ->toString();
    }
}
