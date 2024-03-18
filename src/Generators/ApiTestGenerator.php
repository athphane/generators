<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;

class ApiTestGenerator extends BaseGenerator
{
    /**
     * Render the test
     */
    public function render(): string
    {
        $stub = 'generators::tests/ModelApiControllerTest.stub';

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        return $renderer->appendMultipleContent([
            [
                'search' => '{{keyName}}',
                'keep_search' => false,
                'content' => $this->getKeyName(),
            ],
            [
                'search' => '{{nameField}}',
                'keep_search' => false,
                'content' => $this->getNameField(),
            ],
        ], $template);
    }
}
