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
}
