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
        $default = null
    )
    {
        parent::__construct($name, $nullable, default: $default);
    }

    public function generateFactoryStatement(): string
    {
        return 'boolean()';
    }
}
