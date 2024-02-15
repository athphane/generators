<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\Generators\ViewsGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class ViewsGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_the_component_for_nullable_attributes(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::textarea name="description" :label="__(\'Description\')" inline />', $views_generator->getFormComponentBlade('description'));
    }

    /** @test */
    public function it_can_generate_the_component_for_decimals(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::number name="price" :label="__(\'Price\')" min="0" max="999999999999" step="0.01" required inline />', $views_generator->getFormComponentBlade('price'));
    }

    /** @test */
    public function it_can_generate_the_component_for_ints(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::number name="stock" :label="__(\'Stock\')" min="0" max="4294967295" step="1" required inline />', $views_generator->getFormComponentBlade('stock'));
    }

    /** @test */
    public function it_can_generate_the_component_for_texts(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::textarea name="description" :label="__(\'Description\')" inline />', $views_generator->getFormComponentBlade('description'));
    }

    /** @test */
    public function it_can_generate_the_component_for_strings(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::text name="name" :label="__(\'Name\')" required inline />', $views_generator->getFormComponentBlade('name'));
    }


    /** @test */
    /*public function it_can_generate_the_component_for_booleans(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->boolean()', $views_generator->getFormComponentBlade('on_sale'));
    }*/


    /** @test */
    /*public function it_can_generate_the_component_for_date_times(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->dateTime()?->format(\'Y-m-d H:i\')', $views_generator->getFormComponentBlade('published_at'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_times(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->time()', $views_generator->getFormComponentBlade('sale_time'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_timestamps(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->dateTime()?->format(\'Y-m-d H:i\')', $views_generator->getFormComponentBlade('expire_at'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_dates(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->date()', $views_generator->getFormComponentBlade('released_on'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_years(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->year(2100)', $views_generator->getFormComponentBlade('manufactured_year'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker'."->optional()->passThrough(random_id_or_generate(\App\Models\Category::class, 'id', generate: true))", $views_generator->getFormComponentBlade('category_id'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_json_fields(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->passThrough($this->faker->words())', $views_generator->getFormComponentBlade('features'));
    }*/

    /** @test */
    /*public function it_can_generate_the_component_for_enum_fields(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('$this->faker->randomElement('."['draft', 'published']".')', $views_generator->getFormComponentBlade('status'));
    }*/

    /** @test */
    /*public function it_can_generate_a_views_with_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('products');

        $expected_content = $this->getTestStubContents('factories/ProductViews.php');
        $actual_content = $views_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }*/

    /** @test */
    /*public function it_can_generate_a_views_without_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('categories');

        $expected_content = $this->getTestStubContents('factories/CategoryViews.php');
        $actual_content = $views_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }*/

    /** @test */
    /*public function it_can_generate_a_views_with_multiple_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('orders');

        $expected_content = $this->getTestStubContents('factories/OrderViews.php');
        $actual_content = $views_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }*/
}
