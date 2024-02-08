<?php

namespace Javaabu\Generators\FieldTypes;

class BooleanField extends Field
{
    /**
     * Constructor
     */
    public function __construct(
        string $name,
        bool $nullable = false,
        $default = null,
        bool $unique = false
    )
    {
        parent::__construct(
            $name,
            $nullable,
            default: $default,
            unique: $unique
        );
    }

    public function generateFactoryStatement(): string
    {
        return 'boolean()';
    }

    public function generateValidationRules(): array
    {
        return ['boolean'];
    }

    public function generateCast(): ?string
    {
        return 'boolean';
    }
}
