<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\FieldTypes\BooleanField;
use Javaabu\Generators\FieldTypes\DateField;
use Javaabu\Generators\FieldTypes\DateTimeField;
use Javaabu\Generators\FieldTypes\DecimalField;
use Javaabu\Generators\FieldTypes\EnumField;
use Javaabu\Generators\FieldTypes\Field;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\FieldTypes\IntegerField;
use Javaabu\Generators\FieldTypes\JsonField;
use Javaabu\Generators\FieldTypes\StringField;
use Javaabu\Generators\FieldTypes\TimeField;
use Javaabu\Generators\FieldTypes\YearField;
use Javaabu\Generators\Resolvers\SchemaResolverMySql;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class SchemaResolverMySqlTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_resolve_foreign_key_fields(): void
    {
        $field = $this->resolveField('category_id');

        $this->assertInstanceOf(ForeignKeyField::class, $field);
        $this->assertEquals('category_id', $field->getName());
        $this->assertEquals('categories', $field->getRelatedTable());
        $this->assertEquals('id', $field->getRelatedKeyName());
        $this->assertEquals('Category', $field->getRelatedModelClass());
        $this->assertTrue($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_boolean_fields(): void
    {
        $field = $this->resolveField('on_sale');

        $this->assertInstanceOf(BooleanField::class, $field);
        $this->assertEquals('on_sale', $field->getName());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->getDefault());
        $this->assertTrue($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_string_fields(): void
    {
        $field = $this->resolveField('name');

        $this->assertInstanceOf(StringField::class, $field);
        $this->assertEquals('name', $field->getName());
        $this->assertEquals(255, $field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_integer_fields(): void
    {
        $field = $this->resolveField('stock');

        $this->assertInstanceOf(IntegerField::class, $field);
        $this->assertEquals('stock', $field->getName());
        $this->assertTrue($field->isUnsigned());
        $this->assertEquals(0, $field->getMin());
        $this->assertEquals(4294967295, $field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_decimal_fields(): void
    {
        $field = $this->resolveField('price');

        $this->assertInstanceOf(DecimalField::class, $field);
        $this->assertEquals('price', $field->getName());
        $this->assertTrue($field->isUnsigned());
        $this->assertEquals(14, $field->getTotalDigits());
        $this->assertEquals(2, $field->getPlaces());
        $this->assertEquals(0, $field->getMin());
        $this->assertEquals(999999999999.99, $field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_enum_fields(): void
    {
        $field = $this->resolveField('status');

        $this->assertInstanceOf(EnumField::class, $field);
        $this->assertEquals('status', $field->getName());
        $this->assertEquals(['draft', 'published'], $field->getOptions());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_year_fields(): void
    {
        $field = $this->resolveField('manufactured_year');

        $this->assertInstanceOf(YearField::class, $field);
        $this->assertEquals('manufactured_year', $field->getName());
        $this->assertEquals(1900, $field->getMin());
        $this->assertEquals(2100, $field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_date_time_fields(): void
    {
        $field = $this->resolveField('published_at');

        $this->assertInstanceOf(DateTimeField::class, $field);
        $this->assertEquals('published_at', $field->getName());
        $this->assertNull($field->getMin());
        $this->assertNull($field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());

        $field = $this->resolveField('expire_at');

        $this->assertInstanceOf(DateTimeField::class, $field);
        $this->assertEquals('expire_at', $field->getName());
        $this->assertNull($field->getMin());
        $this->assertNull($field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_date_fields(): void
    {
        $field = $this->resolveField('released_on');

        $this->assertInstanceOf(DateField::class, $field);
        $this->assertEquals('released_on', $field->getName());
        $this->assertNull($field->getMin());
        $this->assertNull($field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_time_fields(): void
    {
        $field = $this->resolveField('sale_time');

        $this->assertInstanceOf(TimeField::class, $field);
        $this->assertEquals('sale_time', $field->getName());
        $this->assertNull($field->getMin());
        $this->assertNull($field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    /** @test */
    public function it_can_resolve_json_fields(): void
    {
        $field = $this->resolveField('features');

        $this->assertInstanceOf(JsonField::class, $field);
        $this->assertEquals('features', $field->getName());
        $this->assertNull($field->getMin());
        $this->assertNull($field->getMax());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
    }

    protected function resolveField($field, $table = 'products'): Field
    {
        $resolver = new SchemaResolverMySql($table, [$field]);
        $fields = $resolver->resolve();

        return $fields[$field];
    }
}
