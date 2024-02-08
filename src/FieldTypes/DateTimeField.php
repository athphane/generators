<?php

namespace Javaabu\Generators\FieldTypes;

class DateTimeField extends DateTypeField
{

    public function generateFactoryStatement(): string
    {
        return 'dateTime()?->format(\'Y-m-d H:i\')';
    }

    public function generateCast(): ?string
    {
        return 'datetime';
    }
}
