<?php

namespace Javaabu\Generators\Support;

class TableProperties
{
    protected array $fields;
    protected bool $soft_deletes;
    protected string $key_name;

    /**
     * Constructor
     */
    public function __construct(array $fields, string $key_name, bool $soft_deletes = false)
    {
        $this->fields = $fields;
        $this->key_name = $key_name;
        $this->soft_deletes = $soft_deletes;
    }

    /**
     * Get the table key name
     */
    public function getKeyName(): string
    {
        return $this->key_name;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return bool
     */
    public function hasSoftDeletes(): bool
    {
        return $this->soft_deletes;
    }


}
