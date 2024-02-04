<?php

namespace Javaabu\Generators\Contracts;

use Javaabu\Generators\Support\TableProperties;

interface SchemaResolverInterface
{
    /**
     * @return array
     */
    public function __construct(string $table, array $columns = []);

    /**
     * Resolve the field types from the schema
     */
    public function resolve(): TableProperties;
}
