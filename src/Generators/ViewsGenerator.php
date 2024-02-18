<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\FieldTypes\Field;

class ViewsGenerator extends BaseGenerator
{
    /**
     * Render the views
     */
    public function render(): string
    {

        return '';

    }

    /**
     * Render the form
     */
    public function renderForm(): string
    {
        $stub = 'generators::views/model/_form.blade.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());
        $form_components = [];

        /**
         * @var string $column
         * @var Field $field
         */
        foreach ($this->getFields() as $column => $field) {
            $form_components[] = $renderer->addIndentation($this->getFormComponentBlade($column) . "\n", 1);
        }

        $template = $renderer->appendMultipleContent([
            [
                'search' => "<x-forms::card>\n",
                'keep_search' => true,
                'content' => $form_components ? implode("\n", $form_components) . "\n" : '',
            ],
        ], $template);

        return $template;
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
