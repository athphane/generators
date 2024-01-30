<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\Resolvers\BaseResolver;
use Javaabu\Generators\Tests\TestCase;

class BaseResolverTest extends TestCase
{
    /** @test */
    public function it_can_determine_the_type_from_attribute(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseResolver::class, ['products']);

        $this->assertEquals('string', $resolver->getAttributeType('name'));
        $this->assertEquals('string', $resolver->getAttributeType('address'));
        $this->assertEquals('text', $resolver->getAttributeType('description'));
        $this->assertEquals('decimal', $resolver->getAttributeType('price'));
        $this->assertEquals('integer', $resolver->getAttributeType('stock'));
        $this->assertEquals('boolean', $resolver->getAttributeType('on_sale'));
        $this->assertEquals('array', $resolver->getAttributeType('features'));
        #$this->assertEquals('enum', $resolver->getAttributeType('status'));
        $this->assertEquals('foreign', $resolver->getAttributeType('category_id'));
        #$this->assertEquals('date', $resolver->getAttributeType('published_at'));

    }

    /** @test */
    public function it_can_generate_model_class_name_from_table_name(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseResolver::class, ['products']);

        $this->assertEquals('Category', $resolver->getModelClassFromTableName('categories'));
        $this->assertEquals('PostType', $resolver->getModelClassFromTableName('post_types'));
        $this->assertEquals('FormInputCategory', $resolver->getModelClassFromTableName('form_input_categories'));
    }

    /** @test */
    public function it_can_get_rule_value_from_attribute(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseResolver::class, ['products']);

        $this->assertEquals('categories,id', $resolver->getAttributeRuleValue('category_id', 'exists'));
    }

    /** @test */
    public function it_can_get_the_foreign_key_table_from_attribute(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseResolver::class, ['products']);

        $this->assertEquals('categories', $resolver->getAttributeForeingKeyTable('category_id'));
    }

    /** @test */
    public function it_can_get_the_foreign_key_name_from_attribute(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseResolver::class, ['products']);

        $this->assertEquals('id', $resolver->getAttributeForeingKeyName('category_id'));
    }

    /** @test */
    public function it_can_get_the_foreign_key_model_class_from_attribute(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseResolver::class, ['products']);

        $this->assertEquals('Category', $resolver->getAttributeForeingKeyModelClass('category_id'));
    }
}
