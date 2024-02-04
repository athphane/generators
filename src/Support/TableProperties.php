<?php

namespace Javaabu\Generators\Support;

class TableProperties
{
    protected array $fields;
    protected bool $soft_deletes;

    /**
     * Constructor
     */
    public function __construct(array $fields, bool $soft_deletes = false)
    {
        $this->fields = $fields;
        $this->soft_deletes = $soft_deletes;
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
