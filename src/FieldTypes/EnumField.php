<?php

namespace Javaabu\Generators\FieldTypes;

class EnumField extends Field
{

    protected array $options;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        array $options,
        bool $nullable = false,
        $default = null
    )
    {
        parent::__construct($name, $nullable, default: $default);

        $this->options = $options;;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
