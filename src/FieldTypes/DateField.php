<?php

namespace Javaabu\Generators\FieldTypes;

class DateField extends DateTypeField
{

    public function generateFactoryStatement(): string
    {
        return 'date()';
    }

    public function generateCast(): ?string
    {
        return 'date';
    }

    public function generateCorrectValue(): string
    {
        return "'2024-02-12'";
    }

    public function generateDifferentCorrectValue(): string
    {
        return "'2023-01-11'";
    }
}
