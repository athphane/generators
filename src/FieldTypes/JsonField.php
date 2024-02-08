<?php

namespace Javaabu\Generators\FieldTypes;

class JsonField extends Field
{

    public function generateFactoryStatement(): string
    {
        return 'passThrough($this->faker->words())';
    }

    public function generateValidationRules(): array
    {
        return ['array'];
    }

    public function generateCast(): ?string
    {
        return 'array';
    }
}
