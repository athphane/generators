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
        $factory_generator = new FactoryGenerator('products');

        $this->assertNull($factory_generator->getFakerMethodFromColumnName('colorful'));
        $this->assertEquals('email', $factory_generator->getFakerMethodFromColumnName('email'));
        $this->assertEquals('firstName', $factory_generator->getFakerMethodFromColumnName('first_name'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_faker_attributes(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->address()', $factory_generator->getFakerStatement('address'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_nullable_attributes(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->optional()->sentences(3, true)', $factory_generator->getFakerStatement('description'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_decimals(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->randomFloat(2, 0, 999999999999)', $factory_generator->getFakerStatement('price'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_ints(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->numberBetween(0, 4294967295)', $factory_generator->getFakerStatement('stock'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_texts(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->optional()->sentences(3, true)', $factory_generator->getFakerStatement('description'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_unique_fields(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->unique()->slug()', $factory_generator->getFakerStatement('slug'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_strings(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->passThrough(ucfirst($this->faker->text(255)))', $factory_generator->getFakerStatement('name'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_booleans(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->boolean()', $factory_generator->getFakerStatement('on_sale'));
    }


    /** @test */
    public function it_can_determine_the_faker_statement_for_date_times(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->dateTime()?->format(\'Y-m-d H:i\')', $factory_generator->getFakerStatement('published_at'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_times(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->time()', $factory_generator->getFakerStatement('sale_time'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_timestamps(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->dateTime()?->format(\'Y-m-d H:i\')', $factory_generator->getFakerStatement('expire_at'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_dates(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->date()', $factory_generator->getFakerStatement('released_on'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_years(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->year(2100)', $factory_generator->getFakerStatement('manufactured_year'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_foreign_keys(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker'."->optional()->passThrough(random_id_or_generate(\App\Models\Category::class, 'id'))", $factory_generator->getFakerStatement('category_id'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_json_fields(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->passThrough($this->faker->words())', $factory_generator->getFakerStatement('features'));
    }

    /** @test */
    public function it_can_determine_the_faker_statement_for_enum_fields(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $this->assertEquals('$this->faker->randomElement('."['draft', 'published']".')', $factory_generator->getFakerStatement('status'));
    }

    /** @test */
    /*public function it_can_generate_a_factory_with_foreign_keys(): void
    {
        $factory_generator = new FactoryGenerator('products');

        $expected_content = $this->getStubContents('factories/ProductFactory.php');
        //$actual_content = $factory_generator->;

        $this->assertEquals($expected_content, $actual_content);
    }*/
}
