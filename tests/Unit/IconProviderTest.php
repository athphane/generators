<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\FieldTypes\DecimalField;
use Javaabu\Generators\IconProviders\MaterialDesignIconicProvider;
use Javaabu\Generators\Tests\TestCase;

class IconProviderTest extends TestCase
{
    /** @test */
    public function it_can_find_appropriate_icons(): void
    {
        $icons = new MaterialDesignIconicProvider();

        $this->assertEquals('file', $icons->findIconFor('file'));
        $this->assertEquals('email', $icons->findIconFor('messages'));
        $this->assertEquals('shopping-cart', $icons->findIconFor('product'));
        $this->assertEquals('email', $icons->findIconFor('emails'));
        $this->assertEquals('cloud-upload', $icons->findIconFor('cloud_file_uploads'));
    }
}
