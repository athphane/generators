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

    public function generateCorrectValue(): string
    {
        return "'2024-02-12 14:54:00'";
    }

    public function generateDifferentCorrectValue(): string
    {
        return "'2023-01-11 13:30:00'";
    }

    public function getFormComponentName(): string
    {
        return 'datetime';
    }
}
