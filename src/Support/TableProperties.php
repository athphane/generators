<?php

namespace Javaabu\Generators\Support;

class TableProperties
{
    protected array $fields;
    protected bool $soft_deletes;
    protected bool $timestamps;
    protected string $key_name;

    /**
     * Constructor
     */
    public function __construct(array $fields, string $key_name, bool $soft_deletes = false, bool $timestamps = true)
    {
        $this->fields = $fields;
        $this->key_name = $key_name;
        $this->soft_deletes = $soft_deletes;
        $this->timestamps = $timestamps;
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

    /**
     * @return bool
     */
    public function hasTimestamps(): bool
    {
        return $this->timestamps;
    }


}
