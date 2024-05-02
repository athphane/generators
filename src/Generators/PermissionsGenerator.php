<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Generators\Concerns\GeneratesPermissions;

class PermissionsGenerator extends BaseGenerator
{
    use GeneratesPermissions;

    protected function getPermissionsStub(): string
    {
        return 'generators::seeders/_permissions' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '') . '.stub';
    }

    /**
     * Render the policy
     */
    public function render(): string
    {
        return $this->renderPermissions();
    }
}
