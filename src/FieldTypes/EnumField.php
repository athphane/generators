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

        $this->options = $options;;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function generateFactoryStatement(): string
    {
        $array = collect($this->getOptions())
            ->transform(function ($value) {
                return "'" . $value. "'";
            })->implode(', ');

        return "randomElement([$array])";
    }
}
