<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\FieldTypes\DateTypeField;
use Javaabu\Generators\FieldTypes\EnumField;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\Generators\Concerns\GeneratesModel;
use Javaabu\Generators\Support\StringCaser;

class ModelGenerator extends BaseGenerator
{
    use GeneratesModel;

    protected string $model_stub = 'generators::Models/Model.stub';
    /**
     * Render the model
     */
    public function render(): string
    {
        return $this->renderModel();
    }

}
