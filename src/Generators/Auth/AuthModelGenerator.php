<?php

namespace Javaabu\Generators\Generators\Auth;

use Javaabu\Generators\Generators\Concerns\GeneratesModel;

class AuthModelGenerator extends BaseAuthGenerator
{
    use GeneratesModel;

    protected string $model_stub = 'generators::Models/AuthModel.stub';

    protected string $model_casts_stub = 'generators::Models/_authCasts.stub';

    public function shouldRenderModelAdminLinkName(): bool
    {
        return false;
    }

    /**
     * Whether soft deletes should be rendered
     */
    public function shouldRenderModelSoftDeletes(): bool
    {
        return false;
    }

    /**
     * Whether searchable should be rendered
     */
    public function shouldRenderModelSearchable(): bool
    {
        return false;
    }

    protected function getAuthColumnFillables(): array
    {
        return [
            'name'
        ];
    }

    public function renderAdditionalModelFillable(): string
    {
        $auth_fillables = $this->getAuthColumnFillables();

        $fillable = '';

        foreach ($auth_fillables as $column) {
            if ($this->isAuthColumn($column)) {
                $fillable .= $this->renderModelFillable($column);
            }
        }

        return $fillable;
    }

    /**
     * Render the views
     */
    public function render(): string
    {
        $template = $this->renderModel();

        $renderer = $this->getRenderer();

        return $renderer->replaceNames($this->getAuthName(), $template, 'AuthName');
    }
}
