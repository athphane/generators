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
    public function getFakerMethodFromAttributeName(string $attribute): ?string
    {
        // don't want to use the name() method
        if ($attribute == 'name') {
            return null;
        }

        $method = Str::camel($attribute);

        try {
            if (method_exists($this->faker, $method) || $this->faker->getFormatter($method)) {
                return $method;
            }
        } catch (\InvalidArgumentException $e) {}

        return null;
    }

    /**
     * Determine fake method attribute
     */
    public function getFakerStatement(string $attribute): ?string
    {
        $is_required = $this->isRequired($attribute);
        $statement = '$this->faker';

        if (! $is_required) {
            $statement .= '->optional()';
        }

        $faker_method = $this->getFakerMethodFromAttributeName($attribute);

        if ($faker_method) {
            $statement .= '->' . $faker_method . '()';
        } elseif($type = $this->getAttributeType($attribute)) {
            switch ($type) {
                case 'decimal':
                    $statement .= '->randomFloat(2)';
                    break;

                case 'integer':
                    $min = $this->getAttributeMin($attribute) ?? 0;
                    $max = $this->getAttributeMax($attribute) ?? 2147483647;
                    $statement .= "->numberBetween($min, $max)";
                    break;

                case 'text':
                    $statement .= '->sentences(3, true)';
                    break;

                case 'string':
                    $statement .= '->passThrough(ucfirst($this->faker->word()))';
                    break;

                case 'boolean':
                    $statement .= '->boolean()';
                    break;

                case 'array':
                    $statement .= '->passThrough($this->faker->words())';
                    break;

                case 'date':
                    $min = $this->getAttributeRuleValue($attribute, 'after_or_equal');
                    $max = $this->getAttributeRuleValue($attribute, 'before_or_equal');

                    if ($min && $max) {
                        $statement .= "->dateTimeBetween($min, $max)";
                    } elseif ($min) {
                        $statement .= "->dateTime($min)";
                    } elseif ($max) {
                        $statement .= "->dateTimeBetween('-30 years', $max)";
                    } else {
                        $statement .= "->dateTime()";
                    }

                    $statement .= '?->format()';

                    break;

                case 'foreign':
                    $model_class = $this->getAttributeForeingKeyModelClass($attribute);
                    $key_name = $this->getAttributeForeingKeyName($attribute);

                    $statement .= '->passThrough(random_id_or_generate(\\App\\Models\\'.$model_class.'::class, \'' . $key_name. '\'))';
                    break;

                case 'enum':
                    $values = $this->getAttributeEnumValues($attribute);
                    $array = collect($values)
                        ->each(function ($value) {
                            return "'$value'";
                        })->implode(', ');

                    $statement .= "->randomElement([$array])";
                    break;

            }
        } else {
            return null;
        }

        return $statement;
    }
}
