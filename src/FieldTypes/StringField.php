<?php

namespace Javaabu\Generators\FieldTypes;

class StringField extends Field
{
    public function generateFactoryStatement(): string
    {
        return 'passThrough(ucfirst($this->faker->text('.$this->getMax().')))';
    }

    public function generateValidationRules(): array
    {
        return ['string', 'max:'.$this->getMax()];
    }

    public function isSearchable(): bool
    {
        return true;
    }

    public function generateCast(): ?string
    {
        return 'string';
    }

    public function isSortable(): bool
    {
        return true;
    }
}
