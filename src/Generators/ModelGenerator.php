<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Generators\Concerns\GeneratesModel;

class ModelGenerator extends BaseGenerator
{
    use GeneratesModel;

    protected string $model_stub = 'generators::Models/Model.stub';

    protected string $model_casts_stub = 'generators::Models/_casts.stub';

    /**
     * Render the model
     */
    public function render(): string
    {
        return $this->renderModel();
    }

}
