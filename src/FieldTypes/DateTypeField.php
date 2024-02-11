<?php

namespace Javaabu\Generators\FieldTypes;

abstract class DateTypeField extends Field
{
    public function generateValidationRules(): array
    {
        return ['date'];
    }

    public function isSortable(): bool
    {
        return true;
    }
}
