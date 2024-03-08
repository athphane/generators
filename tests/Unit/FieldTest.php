<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\FieldTypes\StringField;
use Javaabu\Generators\Tests\TestCase;

class FakeStringField extends StringField
{
    public function shouldRenderInputInline(): bool
    {
        return false;
    }

    public function getFormComponentAttributes(): array
    {
        return ['maxlength' => 255];
    }
}

class FieldTest extends TestCase
{
    /** @test */
    public function it_can_render_field_attributes(): void
    {
        $this->assertEquals('maxlength="255" required :inline="false"', (new FakeStringField('slug'))->renderFormComponentAttributes());
    }

    /** @test */
    public function it_can_render_a_component(): void
    {
        $this->assertEquals('<x-forms::text name="slug" maxlength="255" required :inline="false" />', (new FakeStringField('slug'))->renderFormComponent());
    }
}
