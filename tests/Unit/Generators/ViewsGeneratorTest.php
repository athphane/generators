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

        $this->assertEquals('<x-forms::text name="name" :label="__(\'Name\')" maxlength="255" required inline />', $views_generator->getFormComponentBlade('name'));
    }


    /** @test */
    public function it_can_generate_the_component_for_booleans(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::checkbox name="on_sale" :label="__(\'On Sale\')" value="1" inline />', $views_generator->getFormComponentBlade('on_sale'));
    }


    /** @test */
    public function it_can_generate_the_component_for_date_times(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::datetime name="published_at" :label="__(\'Published At\')" required inline />', $views_generator->getFormComponentBlade('published_at'));
    }

    /** @test */
    public function it_can_generate_the_component_for_times(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::time name="sale_time" :label="__(\'Sale Time\')" required inline />', $views_generator->getFormComponentBlade('sale_time'));
    }

    /** @test */
    public function it_can_generate_the_component_for_timestamps(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::datetime name="expire_at" :label="__(\'Expire At\')" required inline />', $views_generator->getFormComponentBlade('expire_at'));
    }

    /** @test */
    public function it_can_generate_the_component_for_dates(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::date name="released_on" :label="__(\'Released On\')" required inline />', $views_generator->getFormComponentBlade('released_on'));
    }

    /** @test */
    public function it_can_generate_the_component_for_years(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::number name="manufactured_year" :label="__(\'Manufactured Year\')" min="1900" max="2100" step="1" required inline />', $views_generator->getFormComponentBlade('manufactured_year'));
    }

    /** @test */
    public function it_can_generate_the_component_for_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::select name="category" :label="__(\'Category\')" :options="\App\Models\Category::query()" inline />', $views_generator->getFormComponentBlade('category_id'));
    }

    /** @test */
    public function it_can_generate_the_component_for_json_fields(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::select name="features[]" :label="__(\'Features\')" :options="[\'apple\', \'orange\']" multiple required inline />', $views_generator->getFormComponentBlade('features'));
    }

    /** @test */
    public function it_can_generate_the_component_for_enum_fields(): void
    {
        $views_generator = new ViewsGenerator('products');

        $this->assertEquals('<x-forms::select name="status" :label="__(\'Status\')" :options="[\'draft\', \'published\']" required inline />', $views_generator->getFormComponentBlade('status'));
    }

    /** @test */
    public function it_can_generate_a_form_with_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('products');

        $expected_content = $this->getTestStubContents('views/products/_form.blade.php');
        $actual_content = $views_generator->renderForm();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_a_form_without_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('categories');

        $expected_content = $this->getTestStubContents('views/categories/_form.blade.php');
        $actual_content = $views_generator->renderForm();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_a_form_with_multiple_foreign_keys(): void
    {
        $views_generator = new ViewsGenerator('orders');

        $expected_content = $this->getTestStubContents('views/orders/_form.blade.php');
        $actual_content = $views_generator->renderForm();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_model_layout(): void
    {
        $views_generator = new ViewsGenerator('products');

        $expected_content = $this->getTestStubContents('views/products/products.blade.php');
        $actual_content = $views_generator->renderLayout();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_model_create_view(): void
    {
        $views_generator = new ViewsGenerator('products');

        $expected_content = $this->getTestStubContents('views/products/create.blade.php');
        $actual_content = $views_generator->renderCreateView();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_model_edit_view(): void
    {
        $views_generator = new ViewsGenerator('products');

        $expected_content = $this->getTestStubContents('views/products/edit.blade.php');
        $actual_content = $views_generator->renderEditView();

        $this->assertEquals($expected_content, $actual_content);
    }
}
