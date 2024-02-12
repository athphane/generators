<?php

namespace Javaabu\Generators\FieldTypes;

class TextField extends Field
{
    public function generateFactoryStatement(): string
    {
        return 'sentences(3, true)';
    }

    public function generateValidationRules(): array
    {
        return ['string'];
    }

    public function generateCast(): ?string
    {
        return 'string';
    }

    public function generateWrongValue(): string
    {
        return '[]';
    }

    public function generateCorrectValue(): string
    {
        return "'Lorem ipsum'";
    }

    public function generateDifferentCorrectValue(): string
    {
        return "'Itsu bitsum'";
    }
}
