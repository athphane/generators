<?php

namespace Javaabu\Generators\FieldTypes;

class IntegerField extends Field
{

    protected bool $unsigned;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        bool $nullable = false,
        $default = null,
        $min = null,
        $max = null,
        bool $unsigned = false,
        bool $unique = false
    )
    {
        parent::__construct(
            $name,
            $nullable,
            default: $default,
            min: $min,
            max: $max,
            unique: $unique
        );

        $this->unsigned = $unsigned;
    }

    public function isUnsigned(): bool
    {
        return $this->unsigned;
    }

    public function generateFactoryStatement(): string
    {
        $min = $this->getMin();
        $max = $this->getMax();

        return "numberBetween($min, $max)";
    }

    public function generateValidationRules(): array
    {
        return ['integer', 'min:' . $this->getMin(), 'max:' . $this->getMax()];
    }
}
