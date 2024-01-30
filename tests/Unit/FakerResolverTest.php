<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\Resolvers\FactoryResolver;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class FakerResolverTest extends TestCase
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
        $factory_resolver = new FactoryResolver('test');

        $this->assertNull($factory_resolver->getFakerMethodFromAttributeName('colorful'));
        $this->assertEquals('email', $factory_resolver->getFakerMethodFromAttributeName('email'));
        $this->assertEquals('firstName', $factory_resolver->getFakerMethodFromAttributeName('first_name'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_faker_attributes(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker->address()', $factory_resolver->getFakerStatement('address'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_nullable_attributes(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker->optional()->sentences(3, true)', $factory_resolver->getFakerStatement('description'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_decimals(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker->randomFloat(2)', $factory_resolver->getFakerStatement('price'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_ints(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertStringMatchesFormat('$this->faker->numberBetween(%i, %d)', $factory_resolver->getFakerStatement('stock'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_texts(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker->optional()->sentences(3, true)', $factory_resolver->getFakerStatement('description'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_booleans(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker->boolean()', $factory_resolver->getFakerStatement('on_sale'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_dates(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker->dateTime()?->format()', $factory_resolver->getFakerStatement('published_at'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_foreign_keys(): void
    {
        $factory_resolver = new FactoryResolver('products');

        $this->assertEquals('$this->faker'."->optional()->passThrough(random_id_or_generate(\App\Models\Category::class, 'id'))", $factory_resolver->getFakerStatement('category_id'));
    }
}
