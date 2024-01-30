<?php

namespace Javaabu\Generators\FieldTypes;

class DecimalField extends Field
{

    protected bool $unsigned;
    protected int $total_digits;
    protected int $places;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        int $total_digits,
        int $places,
        bool $nullable = false,
        $default = null,
        $min = null,
        $max = null,
        bool $unsigned = false
    )
    {
        parent::__construct($name, $nullable, default: $default, min: $min, max: $max);

        $this->total_digits = $total_digits;
        $this->places = $places;
        $this->unsigned = $unsigned;
    }

    public function isUnsigned(): bool
    {
        return $this->unsigned;
    }

    public function getTotalDigits(): int
    {
        return $this->total_digits;
    }

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function generateFactoryStatement(): string
    {
        return "randomFloat({$this->getPlaces()}, {$this->getMin()}, {$this->getMax()})";
    }
}
