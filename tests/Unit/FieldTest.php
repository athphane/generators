<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\FieldTypes\StringField;
use Javaabu\Generators\Tests\TestCase;

class FakeStringField extends StringField
{
    public function shouldRenderInline(): bool
    {
        return false;
    }

    public function getComponentAttributes(): array
    {
        return ['maxlength' => 255];
    }
}

class FieldTest extends TestCase
{
    /** @test */
    public function it_can_render_field_attributes(): void
    {
        $this->assertEquals('maxlength="255" required :inline="false"', (new FakeStringField('slug'))->renderComponentAttributes());
    }

    /** @test */
    public function it_can_render_a_component(): void
    {
        $this->assertEquals('<x-forms::text name="slug" :label="__(\'Slug\')" maxlength="255" required :inline="false" />', (new FakeStringField('slug'))->renderComponent());
    }
}
