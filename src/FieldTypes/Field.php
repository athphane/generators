<?php

namespace Javaabu\Generators\FieldTypes;

use Javaabu\Generators\Support\StringCaser;

abstract class Field
{

    protected string $name;
    protected bool $nullable;
    protected bool $unique;
    protected $min;
    protected $max;
    protected $default;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        bool $nullable = false,
        $default = null,
        $min = null,
        $max = null,
        bool $unique = false
    )
    {
        $this->name = $name;
        $this->nullable = $nullable;
        $this->min = $min;
        $this->max = $max;
        $this->default = $default;
        $this->unique = $unique;
    }

    public function isRequired(): bool
    {
        return (! $this->isNullable()) && (! $this->hasDefault());
    }

    public function hasDefault(): bool
    {
        return ! is_null($this->getDefault());
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function getInputName(): string
    {
        return $this->getName();
    }

    public function getLabel(): string
    {
        return StringCaser::title($this->getInputName());
    }

    public function isFillable(): bool
    {
        return true;
    }

    public function isSearchable(): bool
    {
        return false;
    }

    public function isSortable(): bool
    {
        return false;
    }

    public function getComponentAttributes(): array
    {
        return [];
    }

    public function shouldRenderInline(): bool
    {
        return true;
    }

    public function renderComponentAttributes(): string
    {
        $attributes = $this->getComponentAttributes();

        if ($this->isRequired()) {
            $attributes['required'] = true;
        }

        $attributes['inline'] = $this->shouldRenderInline();

        $attribs = [];

        foreach ($attributes as $attribute => $value) {
            if (is_bool($value)) {
                $attribs[] = $value ? $attribute : ':' . $attribute . '="false"';
            } else {
                $attribs[] = $attribute . '="' . $value . '"';
            }
        }

        return implode(' ', $attribs);
    }

    public function renderComponent(): string
    {
        $attributes = $this->renderComponentAttributes();

        return '<x-forms::' . $this->getComponentName() . ' name="' . $this->getInputName() . '" :label="__(\'' . $this->getLabel() . '\')" ' . ($attributes ? $attributes . ' ' : '') . '/>';
    }

    public abstract function getComponentName(): string;

    public abstract function generateFactoryStatement(): string;

    public abstract function generateValidationRules(): array;

    public abstract function generateCast(): ?string;

    public abstract function generateWrongValue(): string;

    public abstract function generateCorrectValue(): string;

    public abstract function generateDifferentCorrectValue(): string;

}
