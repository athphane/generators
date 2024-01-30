<?php

namespace Javaabu\Generators\FieldTypes;

class YearField extends Field
{
    public function generateFactoryStatement(): string
    {
        $min = $this->getMin();
        $max = $this->getMax();

        return "year($min, $max)";
    }
}
