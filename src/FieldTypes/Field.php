<?php

namespace Javaabu\Generators\FieldTypes;

abstract class Field
{

    protected string $name;
    protected bool $nullable;
    protected bool $unique;
    protected $min;
    protected $max;
    protected $default;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        bool $nullable = false,
        $default = null,
        $min = null,
        $max = null,
        bool $unique = false
    )
    {
        $this->name = $name;
        $this->nullable = $nullable;
        $this->min = $min;
        $this->max = $max;
        $this->default = $default;
        $this->unique = $unique;
    }

    public function isRequired(): bool
    {
        return ! $this->nullable;
    }

    public function hasDefault(): bool
    {
        return ! is_null($this->getDefault());
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public abstract function generateFactoryStatement(): string;

}
