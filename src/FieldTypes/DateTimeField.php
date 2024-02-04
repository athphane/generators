<?php

namespace Javaabu\Generators\FieldTypes;

class DateTimeField extends Field
{

    public function generateFactoryStatement(): string
    {
        return 'dateTime()?->format(\'Y-m-d H:i\')';
    }

    public function generateValidationRules(): array
    {
        return ['date'];
    }
}
