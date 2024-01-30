<?php

namespace Javaabu\Generators\Resolvers;

use Faker\Generator;
use Illuminate\Support\Str;

class FactoryResolver extends BaseResolver
{
    protected Generator $faker;

    /**
     * Constructor
     */
    public function __construct(string $table, array $columns = [])
    {
        parent::__construct($table, $columns);

        $this->faker = app(Generator::class);
    }

    /**
     * Determine fake method attribute
     */
    public function getFakerMethodFromAttribute(string $attribute): ?string
    {
        $method = Str::camel($attribute);

        try {
            if (method_exists($this->faker, $method) || $this->faker->getFormatter($method)) {
                return $method;
            }
        } catch (\InvalidArgumentException $e) {}

        return null;
    }
}
