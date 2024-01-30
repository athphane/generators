<?php

namespace Javaabu\Generators\Contracts;

interface SchemaResolverInterface
{
    /**
     * @return array
     */
    public function __construct(string $table, array $columns = []);

    /**
     * Resolve the field types from the schema
     */
    public function resolve(): array;
}
