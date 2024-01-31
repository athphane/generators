<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\FieldTypes\BooleanField;
use Javaabu\Generators\FieldTypes\DateField;
use Javaabu\Generators\FieldTypes\DateTimeField;
use Javaabu\Generators\FieldTypes\DecimalField;
use Javaabu\Generators\FieldTypes\EnumField;
use Javaabu\Generators\FieldTypes\ForeignKeyField;
use Javaabu\Generators\FieldTypes\IntegerField;
use Javaabu\Generators\FieldTypes\JsonField;
use Javaabu\Generators\FieldTypes\StringField;
use Javaabu\Generators\FieldTypes\TextField;
use Javaabu\Generators\FieldTypes\TimeField;
use Javaabu\Generators\FieldTypes\YearField;
use Javaabu\Generators\Generators\BaseGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class BaseGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_determine_the_type_from_attribute(): void
    {
        $resolver = $this->getMockForAbstractClass(BaseGenerator::class, ['products']);

        $this->assertInstanceOf(StringField::class, $resolver->getField('name'));
        $this->assertInstanceOf(StringField::class, $resolver->getField('address'));
        $this->assertInstanceOf(TextField::class, $resolver->getField('description'));
        $this->assertInstanceOf(DecimalField::class, $resolver->getField('price'));
        $this->assertInstanceOf(IntegerField::class, $resolver->getField('stock'));
        $this->assertInstanceOf(BooleanField::class, $resolver->getField('on_sale'));
        $this->assertInstanceOf(JsonField::class, $resolver->getField('features'));
        $this->assertInstanceOf(EnumField::class, $resolver->getField('status'));
        $this->assertInstanceOf(ForeignKeyField::class, $resolver->getField('category_id'));
        $this->assertInstanceOf(DateTimeField::class, $resolver->getField('published_at'));
        $this->assertInstanceOf(DateField::class, $resolver->getField('released_on'));
        $this->assertInstanceOf(TimeField::class, $resolver->getField('sale_time'));
        $this->assertInstanceOf(YearField::class, $resolver->getField('manufactured_year'));
    }
}
