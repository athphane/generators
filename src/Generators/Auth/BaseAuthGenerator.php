<?php

namespace Javaabu\Generators\Generators\Auth;

use Illuminate\Support\Facades\Schema;
use Javaabu\Generators\Contracts\SchemaResolverInterface;
use Javaabu\Generators\Generators\BaseGenerator;
use Javaabu\Generators\Support\StringCaser;
use Javaabu\Generators\Support\StubRenderer;
use Javaabu\Generators\Support\TableProperties;

abstract class BaseAuthGenerator extends BaseGenerator
{
    protected string $auth_name;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [], string $auth_name = '')
    {
        $this->auth_name = StringCaser::snake($auth_name) ?: StringCaser::singularSnake($table);

        // remove auth columns
        $columns = $this->removeAuthColumns($table, $columns);

        parent::__construct($table, $columns);
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
