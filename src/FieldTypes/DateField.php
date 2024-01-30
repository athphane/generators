<?php

namespace Javaabu\Generators\FieldTypes;

class DateField extends Field
{

    public function generateFactoryStatement(): string
    {
        return 'dateTime()?->format()';
    }
}
