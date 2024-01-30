<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\Tests\TestCase;

class ForeignKeyFieldTest extends TestCase
{
    /** @test */
    public function it_can_generate_model_class_name_from_table_name(): void
    {
        $this->assertEquals('Category', (new ForeignKeyField('category_id', 'categories', 'id'))->getRelatedModelClass());
        $this->assertEquals('PostType', (new ForeignKeyField('post_type_id', 'post_types', 'id'))->getRelatedModelClass());
        $this->assertEquals('FormInputCategory', (new ForeignKeyField('form_input_category_id', 'form_input_categories', 'id'))->getRelatedModelClass());
    }
}
