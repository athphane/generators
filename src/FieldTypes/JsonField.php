<?php

namespace Javaabu\Generators\FieldTypes;

class JsonField extends Field
{

    public function getFormInputName(): string
    {
        return $this->getInputName() . '[]';
    }

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

    public function generateWrongValue(): string
    {
        return "'foo'";
    }

    public function generateCorrectValue(): string
    {
        return "['apple']";
    }

    public function generateDifferentCorrectValue(): string
    {
        return "['orange']";
    }

    public function getComponentName(): string
    {
        return 'select';
    }

    public function getComponentAttributes(): array
    {
        return [
            ':options' => "['apple', 'orange']",
            'multiple' => true,
        ];
    }
}
