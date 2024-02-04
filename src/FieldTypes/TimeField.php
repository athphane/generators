<?php

namespace Javaabu\Generators\FieldTypes;

class TimeField extends Field
{

    public function generateFactoryStatement(): string
    {
        return 'time()';
    }

    public function generateValidationRules(): array
    {
        return ['date'];
    }
}
