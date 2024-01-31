<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\Generators\FactoryGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class FactoryGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_determine_the_faker_method_from_attribute_name(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertNull($factory_resolver->getFakerMethodFromColumnName('colorful'));
        $this->assertEquals('email', $factory_resolver->getFakerMethodFromColumnName('email'));
        $this->assertEquals('firstName', $factory_resolver->getFakerMethodFromColumnName('first_name'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_faker_attributes(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->address()', $factory_resolver->getFakerStatement('address'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_nullable_attributes(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->optional()->sentences(3, true)', $factory_resolver->getFakerStatement('description'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_decimals(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->randomFloat(2, 0, 999999999999)', $factory_resolver->getFakerStatement('price'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_ints(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->numberBetween(0, 4294967295)', $factory_resolver->getFakerStatement('stock'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_texts(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->optional()->sentences(3, true)', $factory_resolver->getFakerStatement('description'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_unique_fields(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->unique()->slug()', $factory_resolver->getFakerStatement('slug'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_strings(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->passThrough(ucfirst($this->faker->text(255)))', $factory_resolver->getFakerStatement('name'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_booleans(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->boolean()', $factory_resolver->getFakerStatement('on_sale'));
    }


    /** @test */
    public function it_can_determine_the_faker_statement_for_date_times(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->dateTime()?->format(\'Y-m-d H:i\')', $factory_resolver->getFakerStatement('published_at'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_times(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->time()', $factory_resolver->getFakerStatement('sale_time'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_timestamps(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->dateTime()?->format(\'Y-m-d H:i\')', $factory_resolver->getFakerStatement('expire_at'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_dates(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->date()', $factory_resolver->getFakerStatement('released_on'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_years(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->year(2100)', $factory_resolver->getFakerStatement('manufactured_year'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_foreign_keys(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker'."->optional()->passThrough(random_id_or_generate(\App\Models\Category::class, 'id'))", $factory_resolver->getFakerStatement('category_id'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_json_fields(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->passThrough($this->faker->words())', $factory_resolver->getFakerStatement('features'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_enum_fields(): void
    {
        $factory_resolver = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->randomElement('."['draft', 'published']".')', $factory_resolver->getFakerStatement('status'));
    }
}
