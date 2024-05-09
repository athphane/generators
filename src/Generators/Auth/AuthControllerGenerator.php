<?php

namespace Javaabu\Generators\Generators\Auth;

use Javaabu\Generators\Generators\Concerns\GeneratesController;
use Javaabu\Generators\Support\StringCaser;

class AuthControllerGenerator extends BaseAuthGenerator
{
    use GeneratesController;

    public function getControllerStub(): string
    {
        return 'generators::Controllers/Auth/AuthModelSoftDeletesController.stub';
    }

    protected function getControllerFillUpdateIndentation(): int
    {
        return 3;
    }

    protected function getAdditionalControllerEagerLoads(): array
    {
        return [
            "'media'"
        ];
    }

    protected function getAuthColumnOrderbys(): array
    {
        return [
            'name',
            'email',
        ];
    }

    protected function getAdditionalControllerOrderbys(): array
    {
        $orderbys = array_values(array_filter($this->getAuthColumnOrderbys(), [$this, 'isAuthColumn']));

        return $orderbys;
    }

    public function controllersToRender(): array
    {
        return [
            'renderController' => 'Admin/' . StringCaser::pluralStudly($this->getTable()) . 'Controller.php',
        ];
    }



    /**
     * Render the views
     */
    public function render(): string
    {

        $output = '';

        $views = $this->controllersToRender();

        foreach ($views as $method => $file_name) {
            $output .= "// $file_name\n";
            $output .= $this->{$method}();
        }

        return $output;
    }
}
