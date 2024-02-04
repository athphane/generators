<?php

namespace Javaabu\Generators\FieldTypes;

class DateField extends Field
{

    public function generateFactoryStatement(): string
    {
        return 'date()';
    }

    public function generateValidationRules(): array
    {
        return ['date'];
    }
}
