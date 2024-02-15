<?php

namespace Javaabu\Generators\Generators;

class ViewsGenerator extends BaseGenerator
{
    /**
     * Render the policy
     */
    public function render(): string
    {

        return '';

    }

    /**
     * Get the blade code for the column
     */
    public function getFormComponentBlade(string $column): ?string
    {
        $field = $this->getField($column);

        if (! $field) {
            return null;
        }

        return $field->renderComponent();
    }
}
