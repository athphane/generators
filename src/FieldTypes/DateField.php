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
}
