<?php

namespace Javaabu\Generators\FieldTypes;

class TimeField extends DateTypeField
{

    public function generateFactoryStatement(): string
    {
        return 'time()';
    }

    public function generateCast(): ?string
    {
        return 'datetime';
    }
}
