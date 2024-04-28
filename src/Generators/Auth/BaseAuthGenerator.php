<?php

namespace Javaabu\Generators\Generators\Auth;

use Illuminate\Support\Facades\Schema;
use Javaabu\Generators\Generators\BaseGenerator;
use Javaabu\Generators\Support\StringCaser;

abstract class BaseAuthGenerator extends BaseGenerator
{
    protected string $auth_name;
    protected string $default_password;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [], string $auth_name = '')
    {
        $this->auth_name = StringCaser::snake($auth_name) ?: StringCaser::singularSnake($table);

        // remove auth columns
        $columns = $this->removeAuthColumns($table, $columns);

        parent::__construct($table, $columns);

        $this->default_password = $this->generateDefaultPassword();
    }

    /**
     * Get the default password
     */
    public function getDefaultPassword(): string
    {
        return $this->default_password;
    }

    /**
     * Get the default password
     */
    public function generateDefaultPassword(): string
    {
        $file_path = database_path('seeders/DefaultUsersSeeder.php');
        $default_password = '';

        if (file_exists($file_path)) {
            $default_password = $this->extractDefaultPassword($file_path);
        }

        return $default_password ?: StringCaser::singularStudly($this->getTable()) . '@123456';
    }

    /**
     * Extract the default password
     */
    public function extractDefaultPassword(string $file): string
    {
        $contents = file_get_contents($file);

        $matches = [];

        if (preg_match('/\'password\' => \'(.+)\'/', $contents, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Remove auth columns from
     */
    protected function removeAuthColumns(string $table, array $columns): array
    {
        // get all columns if columns not provided
        if (! $columns) {
            $columns = Schema::getColumnListing($table);
        }

        return array_diff($columns, config('generators.auth_skip_columns'));
    }

    public function getAuthName(): string
    {
        return $this->auth_name;
    }

    public function getWebGuardName(): string
    {
        return 'web_' . $this->getMorph();
    }

    public function getApiGuardName(): string
    {
        return 'api_' . $this->getMorph();
    }

    public function getNamespace(): string
    {
        return StringCaser::studly($this->getAuthName());
    }
}
