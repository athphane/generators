<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\Generators\RequestGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class RequestGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_nullable_attributes(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertContains('nullable', $request_generator->getValidationRules('description'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_decimals(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'decimal:0,2',
            'min:0',
            'max:999999999999'
        ], $request_generator->getValidationRules('price'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_ints(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'integer',
            'min:0',
            'max:4294967295'
        ], $request_generator->getValidationRules('stock'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_texts(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'nullable',
            'string'
        ], $request_generator->getValidationRules('description'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_strings(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'string',
            'max:255'
        ], $request_generator->getValidationRules('name'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_booleans(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'boolean'
        ], $request_generator->getValidationRules('on_sale'));
    }


    /** @test */
    public function it_can_determine_the_validation_rules_for_date_times(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getValidationRules('published_at'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_times(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getValidationRules('sale_time'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_timestamps(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getValidationRules('expire_at'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_dates(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getValidationRules('released_on'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_years(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'integer',
            'min:1900',
            'max:2100'
        ], $request_generator->getValidationRules('manufactured_year'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_foreign_keys(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'nullable',
            'exists:categories,id',
        ], $request_generator->getValidationRules('category_id'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_json_fields(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals(['array'], $request_generator->getValidationRules('features'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_enum_fields(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals(['in:draft,published'], $request_generator->getValidationRules('status'));
    }

    /** @test */
    public function it_can_generate_a_request_with_one_unique_rule(): void
    {
        $request_generator = new RequestGenerator('products');

        $expected_content = $this->getTestStubContents('Requests/ProductsRequest.php');
        $actual_content = $request_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_a_request_with_multiple_unique_rules(): void
    {
        $request_generator = new RequestGenerator('categories');

        $expected_content = $this->getTestStubContents('Requests/CategoriesRequest.php');
        $actual_content = $request_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_generate_a_request_with_no_unique_rules(): void
    {
        $request_generator = new RequestGenerator('orders');

        $expected_content = $this->getTestStubContents('Requests/OrdersRequest.php');
        $actual_content = $request_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
