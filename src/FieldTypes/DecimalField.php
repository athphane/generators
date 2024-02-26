<?php

namespace Javaabu\Generators\FieldTypes;

use Illuminate\Support\Str;

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

    public function generateValidationRules(): array
    {
        return ['decimal:0,'.$this->getPlaces(), 'min:'.$this->getMin(), 'max:'.$this->getMax()];
    }

    public function generateCast(): ?string
    {
        return 'decimal:'.$this->getPlaces();
    }

    public function isSortable(): bool
    {
        return true;
    }

    public function generateWrongValue(): string
    {
        return "'foo'";
    }

    public function generateCorrectValue(): string
    {
        return '10.50';
    }

    public function generateDifferentCorrectValue(): string
    {
        return '5.24';
    }

    public function getFormComponentName(): string
    {
        return 'number';
    }

    public function getStep(): string
    {
        if ($places = $this->getPlaces()) {
            return '0.' . Str::repeat('0', $places - 1) . '1';
        }

        return '1';
    }

    public function getFormComponentAttributes(): array
    {
        return [
            'min' => $this->getMin(),
            'max' => $this->getMax(),
            'step' => $this->getStep(),
        ];
    }
}
