<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\Generators\RequestGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Generators\Tests\TestCase;

class RequestGeneratorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_determine_the_validation_rules_for_nullable_attributes(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertContains('nullable', $request_generator->getRequestValidationRules('description'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_decimals(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'decimal:0,2',
            'min:0',
            'max:999999999999'
        ], $request_generator->getRequestValidationRules('price'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_ints(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'integer',
            'min:0',
            'max:4294967295'
        ], $request_generator->getRequestValidationRules('stock'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_texts(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'nullable',
            'string'
        ], $request_generator->getRequestValidationRules('description'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_strings(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'string',
            'max:255'
        ], $request_generator->getRequestValidationRules('name'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_booleans(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'boolean'
        ], $request_generator->getRequestValidationRules('on_sale'));
    }


    /** @test */
    public function it_can_determine_the_validation_rules_for_date_times(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getRequestValidationRules('published_at'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_times(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getRequestValidationRules('sale_time'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_timestamps(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getRequestValidationRules('expire_at'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_dates(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'date',
        ], $request_generator->getRequestValidationRules('released_on'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_years(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'integer',
            'min:1900',
            'max:2100'
        ], $request_generator->getRequestValidationRules('manufactured_year'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_foreign_keys(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals([
            'nullable',
            'exists:categories,id',
        ], $request_generator->getRequestValidationRules('category_id'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_json_fields(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals(['array'], $request_generator->getRequestValidationRules('features'));
    }

    /** @test */
    public function it_can_determine_the_validation_rules_for_enum_fields(): void
    {
        $request_generator = new RequestGenerator('products');

        $this->assertEquals(['in:draft,published'], $request_generator->getRequestValidationRules('status'));
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
