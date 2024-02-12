<?php

namespace Javaabu\Generators\FieldTypes;

class YearField extends Field
{
    public function generateFactoryStatement(): string
    {
        $max = $this->getMax();

        return "year($max)";
    }

    public function generateValidationRules(): array
    {
        return ['integer', 'min:' . $this->getMin(), 'max:' . $this->getMax()];
    }

    public function generateCast(): ?string
    {
        return 'integer';
    }

    public function isSortable(): bool
    {
        return true;
    }

    public function generateWrongValue(): string
    {
        return '-1';
    }

    public function generateCorrectValue(): string
    {
        return '2024';
    }

    public function generateDifferentCorrectValue(): string
    {
        return '2023';
    }
}
