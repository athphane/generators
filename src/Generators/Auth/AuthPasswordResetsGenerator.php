<?php

namespace Javaabu\Generators\Generators\Auth;

use Carbon\Carbon;

class AuthPasswordResetsGenerator extends BaseAuthGenerator
{

    public function getPasswordResetsMigrationName(): string
    {
        $date = Carbon::now()->format('Y_m_d_His');

        return $date . '_create_' . $this->getMorph() . '_password_reset_tokens_table';
    }


    public function render(): string
    {
        $stub = 'generators::migrations/create_auth_password_reset_tokens_table.stub';

        $renderer = $this->getRenderer();

        return $renderer->replaceStubNames($stub, $this->getTable());
    }
}
