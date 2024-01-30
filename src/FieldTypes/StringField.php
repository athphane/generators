<?php

namespace Javaabu\Generators\FieldTypes;

class StringField extends Field
{
    public function generateFactoryStatement(): string
    {
        return 'passThrough(ucfirst($this->faker->text('.$this->getMax().')))';
    }
}
